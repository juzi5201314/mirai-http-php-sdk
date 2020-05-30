<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class App extends Message {

    use Decode, Encode;

    public string $type = "App";

    public string $content;

    public static function encode(string $content) {
        return self::__encode(__METHOD__, func_get_args());
    }
}