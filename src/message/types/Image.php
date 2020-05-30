<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class Image extends Message {

    use Encode, Decode;

    public string $type = "Image";

    public string $imageId;
    public string $url;
    public string $path;


    public static function encode(string $imageId = null, string $url = null, string $path = null) {
        return self::__encode(__METHOD__, func_get_args());
    }

    public static function with_id(string $id) {
        return self::encode($id);
    }

    public static function with_url(string $url) {
        return self::encode(null, $url);
    }

    public static function with_path(string $path) {
        return self::encode(null, null, $path);
    }
}