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
            //TODO: 解析消息
            var_dump($data);
        });
    }
}