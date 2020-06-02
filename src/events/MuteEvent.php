<?php


namespace MiraiSdk\events;


abstract class MuteEvent extends Event {

    public int $operator_id;
    public string $operator_name;
    public int $operator_permission;

    public int $group_id;
    public string $group_name;
    /**
     * 机器人在群里的权限
     */
    public int $group_permission;

    function decode(array $data) {
        if (!is_null($data['operator'])) {
            $this->decode_group_user('operator', $data['operator']);
            $this->decode_group($data['operator']['group']);
        } else {
            $this->decode_group($data['group']);
        }
    }
}