<?php


namespace MiraiSdk\message\types;

use MiraiSdk\message\Decode;
use MiraiSdk\message\Message;

class Quote extends Message {

    use Decode;

    public string $type = "Quote";

    public int $id;
    public int $groupId;
    public int $senderId;
    public int $targetId;
    /** @var Message[] $origin */
    public array $origin;

    public static function decode(array $data): Quote {
        $quote = new static();
        $quote->id = $data["id"];
        $quote->groupId = $data["groupId"];
        $quote->senderId = $data["senderId"];
        $quote->targetId = $data["targetId"];
        /** @var array $origin */
        foreach ($data["origin"] as $origin) {
            $quote->origin[] = self::auto_decode($origin);
        }
        return $quote;
    }
}