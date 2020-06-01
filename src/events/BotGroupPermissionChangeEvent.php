<?php


namespace MiraiSdk\events;


class BotGroupPermissionChangeEvent extends Event {

    public int $origin;
    public int $current;

    public int $group_id;
    public string $group_name;
    /**
     * 机器人在群里的权限
     */
    public int $group_permission;

    function decode(array $data) {
        $this->origin = self::get_permission($data['origin']);
        $this->current = self::get_permission($data['current']);
        $this->decode_group($data['group']);
    }
}