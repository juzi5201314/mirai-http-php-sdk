<?php


namespace MiraiSdk\events;


class GroupMuteAllEvent extends MuteEvent {

    public bool $origin;
    public bool $current;

    public function decode(array $data) {
        parent::decode($data);
        $this->origin = $data['origin'];
        $this->current = $data['current'];
    }

}