<?php

namespace MiraiSdk;

use Amp\ByteStream;
use Amp\Log\ConsoleFormatter;
use Amp\Log\StreamHandler;

trait Logger {

    private \Monolog\Logger $logger;

    public abstract function get_name(): string;
    public abstract function get_config(): BotConfig;

    private function init_logger() {
        if ($this->get_config()->enable_logger) {
            $handler = new StreamHandler(ByteStream\getStdout(), $_ENV['LOG_LEVEL'] ?? "debug");
            $handler->setFormatter(new ConsoleFormatter("[%datetime%] %channel%.%level_name%: %message%\r\n"));

            $logger = new \Monolog\Logger($this->get_name());
            $logger->pushHandler($handler);

            $this->logger = $logger;
        } else {
            $this->logger = new class('') extends \Monolog\Logger {
                public function addRecord(int $level, string $message, array $context = []): bool {
                    return false;
                }
            };
        }
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

}