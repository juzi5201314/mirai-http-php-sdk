<?php


namespace MiraiSdk;

use Throwable;

class ApiError extends \Exception {

    //api调用过程中产生的其他错误。如http错误，json解析错误等
    const KIND_OTHER = -1;

    // 除了other，其他与mirai http api的错误代码相同
    public int $kind;

    public function __construct(string $message, int $kind = -1) {
        parent::__construct($message, 0, null);
        $this->kind = $kind;
    }

}