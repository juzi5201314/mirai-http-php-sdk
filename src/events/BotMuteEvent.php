<?php


namespace MiraiSdk\events;


class BotMuteEvent extends MuteEvent {

    /**
     * 禁言时间，单位：秒
     */
    public int $time;

    public function decode(array $data) {
        parent::decode($data);
        $this->time = $data['durationSeconds'];
    }

}