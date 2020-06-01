<?php


namespace MiraiSdk\events;


use Amp\Loop;
use Amp\Promise;
use Amp\Success;
use function Amp\call;

trait Listener {

    /**
     * 每次fetch的消息数量
     */
    public int $fetch_count = 5;

    public abstract function fetch_message(int $count): Promise;

    /**
     * @param int $interval 每次循环fetch message的间隔，0为死循环不间断
     * @return Promise
     */
    public function loop_listen(int $interval = 200): Promise {
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
            $data = yield $this->fetch_message($this->fetch_count);
            foreach ($data as $event_data) {
                $type = $event_data['type'] ?? 'Unknown';

                // message类型结尾没有Event 5个字母，手动补上
                if (substr($type, -7) == 'Message')
                    $type = $type . 'Event';

                $class_name = 'MiraiSdk\\events\\' . $type;
                if (class_exists($class_name)) {
                    /** @var Event $event */
                    $event = new $class_name;
                    $event->decode($event_data);
                    var_dump($event);
                } else {
                    throw new \Exception("未知的事件类型: " . $type);
                }
            }
        });
    }
}