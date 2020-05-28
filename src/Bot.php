<?php


namespace MiraiSdk;

class Bot {

    use Logger, Api;

    public function __construct(string $addr) {
        $this->addr = $addr;
    }

    public function get_name(): string {
        return 'name';
    }
}