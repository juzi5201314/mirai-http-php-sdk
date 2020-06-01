<?php


namespace MiraiSdk\events;


class FriendMessageEvent extends MessageEvent {

    public int $id;
    public string $name;
    public string $remark;

    public function decode(array $data) {
        parent::decode($data);
        $this->id = $data['sender']['id'];
        $this->name = $data['sender']['nickname'];
        $this->remark = $data['sender']['remark'];
    }

}