<?php


namespace MiraiSdk\events;


abstract class GroupMemberInfoChangeEvent extends Event {

    // 为了兼容MemberPermissionChangeEvent的int，不限制类型
    public $origin;
    public $current;

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
        $this->origin = $data['origin'];
        $this->current = $data['current'];
        $this->decode_group_user('member', $data['member']);
        $this->decode_group($data['member']['group']);
    }
}