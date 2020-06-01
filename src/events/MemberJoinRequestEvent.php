<?php


namespace MiraiSdk\events;


class MemberJoinRequestEvent extends RequestEvent {

    public string $group_name;

    public function decode(array $data) {
        parent::decode($data);
        $this->group_name = $data['groupName'];
    }

}