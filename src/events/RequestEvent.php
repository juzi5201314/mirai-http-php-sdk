<?php


namespace MiraiSdk\events;


abstract class RequestEvent extends Event {

    public int $event_id;
    public int $from_id;
    public int $group_id;

    public string $nick;

    public function decode(array $data) {
        $this->event_id = $data['eventId'];
        $this->from_id = $data['fromId'];
        $this->group_id = $data['groupId'];
        $this->nick = $data['nick'];
    }
}