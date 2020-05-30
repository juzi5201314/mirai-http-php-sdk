<?php


namespace MiraiSdk\message;


trait Encode {

    public static function encode() {
        return new static();
    }

    private static function __encode(string $method, array $args): self {
        $method = new \ReflectionMethod($method);
        $params = $method->getParameters();
        $msg = new static();
        foreach ($args as $pos => $val) {
            if ($val == null)
                continue;
            $param = $params[$pos];
            $msg->{$param->getName()} = $val;
        }
        return $msg;
    }
}