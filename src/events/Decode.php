<?php


namespace MiraiSdk\events;


trait Decode {

    public function decode_group_user(string $name, array $data) {
        $this->{$name . '_id'} = $data['id'];
        $this->{$name . '_name'} = $data['memberName'];
        $this->{$name . '_permission'} = self::get_permission($data['permission']);
    }

    public function decode_group(array $data) {
        $this->group_id = $data['id'];
        $this->group_name = $data['name'];
        $this->group_permission = self::get_permission($data['permission']);
    }

    public static function get_permission(string $permission_str): int {
        return constant('MiraiSdk\\events\\Event::PERMISSION_' . $permission_str) ?? 0;
    }

    abstract function decode(array $data);

}