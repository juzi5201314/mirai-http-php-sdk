<?php

namespace MiraiSdk;

use Amp\ByteStream;
use Amp\Log\ConsoleFormatter;
use Amp\Log\StreamHandler;

trait Logger {

    /** @var \Monolog\Logger */
    private $logger;

    /**
     * 不能调用abstract static function真的烦
     * @return string
     */
    public abstract function get_name(): string;

    private function init_logger() {
        $handler = new StreamHandler(ByteStream\getStdout());
        $handler->setFormatter(new ConsoleFormatter("[%datetime%] %channel%.%level_name%: %message%\r\n"));

        $logger = new \Monolog\Logger($this->get_name());
        $logger->pushHandler($handler);

        $this->logger = $logger;
    }

    private function get_logger_or_init(): \Monolog\Logger {
        if (empty($this->logger))
            $this->init_logger();
        return $this->logger;
    }

    public function info(string $message) {
        $this->get_logger_or_init()->info($message);
    }

    public function debug(string $message) {
        $this->get_logger_or_init()->debug($message);
    }

    public function alert(string $message) {
        $this->get_logger_or_init()->alert($message);
    }

    public function critical(string $message) {
        $this->get_logger_or_init()->critical($message);
    }

    public function error(string $message) {
        $this->get_logger_or_init()->error($message);
    }

    public function warning(string $message) {
        $this->get_logger_or_init()->warning($message);
    }

    public function notice(string $message) {
        $this->get_logger_or_init()->notice($message);
    }

    public function close_logger() {
        $this->info(sprintf("Logger #%s closed.", $this->get_name()));
        $this->get_logger_or_init()->close();
    }

}