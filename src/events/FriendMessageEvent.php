<?php


namespace MiraiSdk\events;


class FriendMessageEvent extends MessageEvent {

    public int $id;
    public string $name;
    public string $remark;

    public function decode(array $data) {
        parent::decode($data);
        $this->id = $data['id'];
        $this->name = $data['nickname'];
        $this->remark = $data['remark'];
    }

}