<?php


namespace MiraiSdk\events;


use MiraiSdk\Bot;

abstract class Event {

    use Decode;

    public Bot $bot;

    const PERMISSION_MEMBER = 0;
    const PERMISSION_ADMINISTRATOR = 1;
    const PERMISSION_OWNER = 2;
}