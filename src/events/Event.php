<?php


namespace MiraiSdk\events;


abstract class Event {

    use Decode;

    const PERMISSION_MEMBER = 0;
    const PERMISSION_ADMINISTRATOR = 1;
    const PERMISSION_OWNER = 2;
}