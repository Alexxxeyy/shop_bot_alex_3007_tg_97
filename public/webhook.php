<?php
require_once __DIR__ . "/../vendor/autoload.php";
use app\components\Telegram;

$data = Telegram::getInputData();

if (isset($data['message'])) {
    if ($data['message']['chat']['id'] !== Telegram::CHAT_ID) {
        exit;
    }
    Bot::processMessage($data['message']);
} elseif (isset($data['callback_query'])) {
    if ($data['callback_query']['chat']['id'] !== Telegram::CHAT_ID) {
        exit;
    }
    Bot::processCallback($data['message']);
}

file_put_contents(
    __DIR__ . '/../storage/logs/webhook.log',
    print_r($data, true) . PHP_EOL . PHP_EOL,
    FILE_APPEND
);

