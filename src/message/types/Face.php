<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class Face extends Message {

    use Decode, Encode;

    public string $type = "Face";

    public int $faceId;
    public string $name;

    public static function encode(int $faceId = null, string $name = null) {
        return self::__encode(__METHOD__, func_get_args());
    }

    public static function with_id(int $id) {
        return self::encode($id);
    }

    public static function with_name(string $name) {
        return self::encode(null, $name);
    }

}