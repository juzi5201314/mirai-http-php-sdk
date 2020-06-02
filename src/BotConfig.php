<?php


namespace MiraiSdk;


class BotConfig {

    public int $qq;
    public string $token;
    public string $addr;

    /** 每次循环fetch message的间隔，0为死循环不间断 */
    public int $loop_interval = 200;
    /** 每次循环fetch message的消息数量 */
    public int $fetch_count = 5;
    public bool $enable_logger = true;


    public function __construct(string $addr, int $qq, string $token) {
        $this->addr = $addr;
        $this->qq = $qq;
        $this->token = $token;
    }

    public function loop_interval(int $loop_interval = 200): self {
        $this->loop_interval = $loop_interval;
        return $this;
    }

    public function fetch_count(int $fetch_count): self {
        $this->fetch_count = $fetch_count;
        return $this;
    }

    public function enable_logger(int $enable_logger): self {
        $this->enable_logger = $enable_logger;
        return $this;
    }

}