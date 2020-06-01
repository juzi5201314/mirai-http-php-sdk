<?php


namespace MiraiSdk\message;

abstract class Message {

    // abstract
    public string $type;

    public static function from_array(array $data) {
        $class_name = "MiraiSdk\\message\\types\\" . $data["type"];
        if (class_exists($class_name) && in_array(Decode::class, class_uses($class_name)))
            return $class_name::decode($data);
        else
            throw new \Exception("未知的消息类型: " . $data["type"]);
    }

}