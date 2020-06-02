<?php


namespace MiraiSdk;

use Amp\Promise;
use MiraiSdk\events\Listener;
use function Amp\call;

class Bot {

    use Logger, Api, Listener;

    public BotConfig $config;

    /**
     * Bot constructor.
     * @param BotConfig $config
     */
    public function __construct(BotConfig $config) {
        $this->config = $config;
    }

    public function get_config(): BotConfig {
        return $this->config;
    }

    public function get_bot(): Bot {
        return $this;
    }

    public function activate(): Promise {
        return call(function () {
            yield $this->auth($this->config->token);
            yield $this->verify();
            $this->info(sprintf("Bot %s activated.", $this->get_name()));
        });
    }

    public function run(): Promise {
        return call(function () {
            yield $this->activate();
            yield $this->loop_listen();
            $this->info(sprintf("Bot %s running.", $this->get_name()));
        });
    }

    /**
     * 不阻塞的运行
     */
    public function run_no_blocking() {
        Promise\rethrow($this->run());
    }

    public function get_name(): string {
        return '#'.$this->config->qq;
    }

    public function get_qq(): int {
        return $this->config->qq;
    }

    /**
     * 对象销毁时，释放session
     * 大部分时候，bot对象销毁时Loop已经结束，无法再使用任何异步操作
     *
     * 在程序被强行杀死的时候不会触发，所以最好使用监听信号等方法，在程序正常退出时调用Loop::stop来停止循环
     */
    public function __destruct() {
        if (!empty($this->session) && $this->sync_release()) {
            print sprintf("Session %s Released.\r\n", $this->session);
        }
        print sprintf("Bot %s Destroyed.\r\n", $this->get_name());
    }
}