<?php


namespace MiraiSdk\tests;


use Amp\PHPUnit\AsyncTestCase;
use MiraiSdk\message\types\At;
use MiraiSdk\message\types\AtAll;
use MiraiSdk\message\types\Face;
use MiraiSdk\message\types\Image;
use MiraiSdk\message\types\Plain;
use MiraiSdk\message\types\Quote;

class MessageTest extends AsyncTestCase {

    public function test_quote() {
        $data = [
            "id" => 1,
            "groupId" => 2,
            "senderId" => 3,
            "targetId" => 4,
            "origin" => [
                ["type" => "Source", "id" => 100, "time" => 101],
                ["type" => "Plain", "text" => "hi"]
            ]
        ];
        $this->assertEquals("Plain", Quote::decode($data)->origin[1]->type);
    }

    public function test_at() {
        $at = At::encode(12345);
        $this->assertEquals(12345, $at->target);
    }

    public function test_at_all() {
        $at_all = AtAll::encode();
        $this->assertEquals("AtAll", $at_all->type);
    }

    public function test_plain() {
        $plain = Plain::encode("hi");
        $this->assertEquals("hi", $plain->text);
    }

    public function test_face() {
        $face = Face::with_name("huaji");
        $this->assertEquals("huaji", $face->name);
    }

    public function test_image() {
        $image = Image::with_url("http://qq.com/a.png");
        $this->assertEquals("http://qq.com/a.png", $image->url);
    }

}