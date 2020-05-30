<?php

namespace MiraiSdk\tests;

use Amp\PHPUnit\AsyncTestCase;
use MiraiSdk\Bot;
use MiraiSdk\message\types\Face;
use MiraiSdk\message\types\FlashImage;
use MiraiSdk\message\types\Image;
use MiraiSdk\message\types\Plain;
use MiraiSdk\message\types\Poke;
use MiraiSdk\message\types\Source;
use Symfony\Component\Dotenv\Dotenv;

class BotTest extends AsyncTestCase {

    private static Bot $bot;

    public static function setUpBeforeClass(): void {
        parent::setUpBeforeClass();
        $dotenv = new Dotenv();
        $dotenv->load('.env.test');
        self::$bot = new Bot($_ENV["ADDR"], $_ENV["QQ"], $_ENV["TOKEN"]);
        self::$bot->run_no_blocking();;
    }

    public function test_log() {
        self::$bot->info("test info");
        self::$bot->debug("test debug");
        self::$bot->warning("test warning");
        self::$bot->error("test error");
        self::$bot->notice("test notice");
        self::$bot->alert("test alert");
        self::$bot->critical("test critical");
    }

    public function test_api_about() {
        $about = yield self::$bot->about();
        self::$bot->debug(var_export($about, true));
    }

    public function test_friend_message() {
        yield self::$bot->send_friend_message($_ENV["TARGET_QQ"], [
            Plain::encode("hi"),
            Face::encode(1),
            FlashImage::with_url("https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png")
        ]);
    }

    // 给每个测试添加一个必定成功的断言
    // 为了避免phpunit 测试里没有执行断言就认为出错的zz行为。
    public function setUp(): void {
        parent::setUp();
        $this->assertTrue(true);
    }
}
