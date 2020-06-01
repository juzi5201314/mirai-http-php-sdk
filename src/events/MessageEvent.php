<?php


namespace MiraiSdk\events;


use MiraiSdk\message\Message;

abstract class MessageEvent extends Event {

    /** @var Message[] $messages */
    public array $messages = [];

    public function decode(array $data) {
        foreach ($data['messageChain'] as $msg_data) {
            $this->messages[] = Message::from_array($msg_data);
        }
    }

}