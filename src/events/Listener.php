<?php


namespace MiraiSdk\events;


use Amp\Loop;
use Amp\Promise;
use Amp\Success;
use MiraiSdk\Bot;
use MiraiSdk\BotConfig;
use function Amp\call;
use function PHPUnit\Framework\callback;

trait Listener {

    private array $listeners = [];

    public abstract function get_bot(): Bot;
    public abstract function get_config(): BotConfig;
    public abstract function fetch_message(int $count): Promise;

    /**
     * @return Promise
     */
    public function loop_listen(): Promise {
        $interval = $this->get_config()->loop_interval;
        $this->get_bot()->info(sprintf("fetch %s messages every %dms.", $this->get_config()->fetch_count, $interval));
        if ($interval > 0) {
            Loop::repeat($interval, fn() => yield $this->listen_once());
            return new Success();
        } else {
            return call(function () {
                while (true) {
                    yield $this->listen_once();
                }
            });
        }
    }

    public function listen_once(): Promise {
        return call(function () {
            $data = yield $this->fetch_message($this->get_config()->fetch_count);

            if (($count = count($data)) > 0)
                $this->get_bot()->debug(sprintf("fetch %s messages.", $count));

            yield array_map(function ($event_data) {
                return call(function () use($event_data) {
                    $type = $event_data['type'] ?? 'Unknown';

                    // message类型结尾没有Event 5个字母，手动补上
                    if (substr($type, -7) == 'Message')
                        $type = $type . 'Event';

                    $class_name = 'MiraiSdk\\events\\' . $type;
                    if (class_exists($class_name)) {
                        /** @var Event $event */
                        $event = new $class_name;
                        $event->bot = $this->get_bot();
                        $event->decode($event_data);

                        foreach ($this->listeners as $class => $callbacks) {
                            if ($event instanceof $class)
                                yield array_map(fn($callback) => call($callback, $event), $callbacks);
                        }
                    } else {
                        throw new \Exception("未知的事件类型: " . $type);
                    }
                });
            }, $data);
        });
    }

    /**
     * @param string $class
     * @param callable $fn (Event)
     * @return bool
     */
    public function register_listener(string $class, callable $fn): bool {
        if ($class_exist = class_exists($class))
            $this->listeners[$class][] = $fn;
        return $class_exist;
    }
}