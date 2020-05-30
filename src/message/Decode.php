<?php


namespace MiraiSdk\message;


use MiraiSdk\message\Message;

trait Decode {

    public static function decode(array $data): Message {
        return self::auto_decode($data);
    }

    /**
     * @param array $data
     * @return Message
     * @throws \ReflectionException
     */
    public static function auto_decode(array $data): Message {
        $class_name = "MiraiSdk\\message\\types\\".$data["type"];
        if (class_exists($class_name)) {
            $class = new \ReflectionClass($class_name);
            /** @var Message $msg */
            $msg = $class->newInstance();
            foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
                $name = $property->getName();
                if (isset($data[$name])) {
                    $msg->$name = $data[$name];
                }
            }
            return $msg;
        } else {
            throw new \Exception("未知的消息类型: " . $data["type"]);
        }
    }

}