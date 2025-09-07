<?php
require_once __DIR__ . "/vendor/autoload.php";

use app\components\Telegram;

$data = Telegram::getInputData();

file_put_contents(
    __DIR__ . '/../storage/logs/webhook.log',
    print_r($data, 1) . PHP_EOL . PHP_EOL,
    FILE_APPEND
);
Telegram::sendMessage($data['message']['text']);
