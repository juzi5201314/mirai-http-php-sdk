<?php


namespace MiraiSdk\events;


abstract class RecallEvent extends Event {

    public int $user_id;
    public int $message_id;
    public int $time;

    public function decode(array $data) {
        $this->user_id = $data['authorId'];
        $this->message_id = $data['messageId'];
        $this->time = $data['time'];
    }

}