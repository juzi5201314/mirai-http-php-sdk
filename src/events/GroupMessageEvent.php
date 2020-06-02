<?php


namespace MiraiSdk\events;


use MiraiSdk\message\Message;

class GroupMessageEvent extends MessageEvent {

    public int $sender_id;
    public string $sender_name;
    public int $sender_permission;

    public int $group_id;
    public string $group_name;
    /**
     * 机器人在群里的权限
     */
    public int $group_permission;

    public function decode(array $data) {
        parent::decode($data);
        $this->decode_group_user('sender', $data['sender']);
        $this->decode_group($data['sender']['group']);
    }

    public function reply(array $messages, bool $quote = true) {
        $this->bot->send_group_message($this->group_id, $messages, $quote ? $this->get_message_id() : null);
    }
}