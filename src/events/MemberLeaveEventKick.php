<?php


namespace MiraiSdk\events;


class MemberLeaveEventKick extends GroupMemberChangeEvent {

    public int $operator_id;
    public string $operator_name;
    public int $operator_permission;

    public function decode(array $data) {
        parent::decode($data);
        if (!is_null($data['operator']))
            $this->decode_group_user('operator', $data['operator']);
    }

}