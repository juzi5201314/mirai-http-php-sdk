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
}