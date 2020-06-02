<?php


namespace MiraiSdk\events;


use MiraiSdk\message\Message;
use MiraiSdk\message\types\Source;

abstract class MessageEvent extends Event {

    /** @var Message[] $messages */
    public array $messages = [];

    public function decode(array $data) {
        foreach ($data['messageChain'] as $msg_data) {
            $this->messages[] = Message::from_array($msg_data);
        }
    }

    public function get_message_id(): int {
        $source = $this->messages[0];
        if ($source instanceof Source) {
            return $source->id;
        } else {
            return 0;
        }
    }

}