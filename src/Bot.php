<?php


namespace MiraiSdk;

use Amp\Promise;
use function Amp\call;

class Bot {

    use Logger, Api;

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

    public function run(): Promise {
        return call(function () {
           yield $this->activate();
           // TODO: 轮询接收消息
        });
    }

    public function run_no_blocking() {
        Promise\wait($this->activate());
        // TODO: 轮询接收消息
        //Promise\rethrow($this->run());
    }

    public function get_name(): string {
        return '#'.$this->qq;
    }

    public function get_qq(): int {
        return $this->qq;
    }

    // 貌似有点问题，但是无法复现
    public function __destruct() {
        Promise\wait($this->release());
        print sprintf("Bot %s Destroyed.", $this->get_name());
    }
}