<?php


namespace MiraiSdk\events;


abstract class GroupMemberChangeEvent extends Event {

    public int $member_id;
    public string $member_name;
    public int $member_permission;

    public int $group_id;
    public string $group_name;
    /**
     * 机器人在群里的权限
     */
    public int $group_permission;

    function decode(array $data) {
        $this->decode_group_user('member', $data['member']);
        $this->decode_group($data['member']['group']);
    }
}