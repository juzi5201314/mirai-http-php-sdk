<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class Plain extends Message {

    use Decode, Encode;

    public string $type = "Plain";

    public string $text;

    public static function encode(string $text) {
        return self::__encode(__METHOD__, func_get_args());
    }

}