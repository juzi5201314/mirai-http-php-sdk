<?php


namespace MiraiSdk\message\types;


use MiraiSdk\message\Decode;
use MiraiSdk\message\Encode;
use MiraiSdk\message\Message;

class AtAll extends Message {

    use Decode, Encode;

    public string $type = "AtAll";

}