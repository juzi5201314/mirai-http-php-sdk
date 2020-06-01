<?php


namespace MiraiSdk\events;


abstract class BotGroupChangeEvent extends Event {

    public int $group_id;
    public string $group_name;
    /**
     * 机器人在群里的权限
     */
    public int $group_permission;

    function decode(array $data) {
        $this->decode_group($data);
    }
}