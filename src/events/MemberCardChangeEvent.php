<?php


namespace MiraiSdk\events;


class MemberCardChangeEvent extends GroupMemberInfoChangeEvent {

    public int $operator_id;
    public string $operator_name;
    public int $operator_permission;

    public function decode(array $data) {
        parent::decode($data);
        $this->decode_group_user('operator', $data['operator']);
    }

}