<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class Xml extends Message {

    use Decode, Encode;

    public string $type = "Xml";

    public string $xml;

    public static function encode(string $xml) {
        return self::__encode(__METHOD__, func_get_args());
    }

}