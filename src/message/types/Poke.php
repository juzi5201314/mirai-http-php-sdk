<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class Poke extends Message {

    use Decode, Encode;

    public string $type = "Poke";

    public string $name;

    public static function encode(string $name) {
        return self::__encode(__METHOD__, func_get_args());
    }
}