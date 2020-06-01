<?php


namespace MiraiSdk\events;


abstract class BotStatusChangeEvent extends Event {

    public int $qq;

    function decode(array $data) {
        $this->qq = $data['qq'];
    }

}