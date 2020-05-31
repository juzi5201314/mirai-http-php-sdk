<?php


namespace MiraiSdk;

use Amp\Promise;
use MiraiSdk\events\Listener;
use function Amp\call;

class Bot {

    use Logger, Api, Listener;

    public int $qq;
    private string $token;

    /**
     * Bot constructor.
     * @param string $addr
     * @param int $qq
     * @param string $token
     */
    public function __construct(string $addr, int $qq, string $token) {
        $this->addr = $addr;
        $this->qq = $qq;
        $this->token = $token;
    }

    public function activate(): Promise {
        return call(function () {
            yield $this->auth($this->token);
            yield $this->verify();
        });
    }

    public function run(int $loop_interval = 200): Promise {
        return call(function () use($loop_interval) {
            yield $this->activate();
            yield $this->loop_listen($loop_interval);
        });
    }

    /**
     * 不阻塞的运行
     *
     * @param int $loop_interval
     */
    public function run_no_blocking(int $loop_interval = 200) {
        Promise\rethrow($this->run($loop_interval));
    }

    public function get_name(): string {
        return '#'.$this->qq;
    }

    public function get_qq(): int {
        return $this->qq;
    }

    /**
     * 对象销毁时，释放session
     * 大部分时候，bot对象销毁时Loop已经结束，无法再使用异步release
     *
     * 在程序被强行杀死的时候不会触发，所以最好使用监听信号等方法，调用Loop::stop来停止循环
     */
    public function __destruct() {
        if (!empty($this->session) && $this->sync_release()) {
            print sprintf("Session %s Released.\r\n", $this->session);
        }
        print sprintf("Bot %s Destroyed.\r\n", $this->get_name());
    }
}