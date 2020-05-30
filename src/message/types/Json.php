<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class Json extends Message {

    use Decode, Encode;

    public string $type = "Json";

    public string $json;

    public static function encode(string $json) {
        return self::__encode(__METHOD__, func_get_args());
    }
}