<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Message;

class Source extends Message {

    use Decode;

    public string $type = "Source";

    public int $id;
    public int $time;
}