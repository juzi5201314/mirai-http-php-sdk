<?php


namespace MiraiSdk\events;


class FriendRecallEvent extends RecallEvent {

    public int $operator_id;

    public function decode(array $data) {
        parent::decode($data);
        $this->operator_id = $data['operator'];
    }

}