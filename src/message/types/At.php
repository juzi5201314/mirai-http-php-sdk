<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class At extends Message {

    use Encode, Decode;

    public string $type = "At";

    public int $target;
    public string $display;

    public static function encode(int $target) {
        return self::__encode(__METHOD__, func_get_args());
    }

}