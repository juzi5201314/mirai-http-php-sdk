<?php


namespace MiraiSdk\events;


class MemberUnmuteEvent extends MuteEvent {

    public int $member_id;
    public string $member_name;
    public int $member_permission;

    public function decode(array $data) {
        parent::decode($data);
        $this->decode_group_user('member', $data['member']);
    }

}