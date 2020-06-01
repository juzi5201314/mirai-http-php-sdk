<?php


namespace MiraiSdk\events;


class MemberMuteEvent extends MuteEvent {

    /**
     * 禁言时间，单位：秒
     */
    public int $time;

    public int $member_id;
    public string $member_name;
    public int $member_permission;

    public function decode(array $data) {
        parent::decode($data);
        $this->time = $data['durationSeconds'];
        $this->decode_group_user('member', $data['member']);
    }

}