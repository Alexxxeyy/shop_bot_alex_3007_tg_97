<?php
require_once __DIR__ . "/../vendor/autoload.php";
use app\components\Telegram;

$data = Telegram::getInputData();

if (
    !isset($data['message']['chat']['id']) ||
    (string)$data['message']['chat']['id'] !== (string)Telegram::CHAT_ID
) {
    http_response_code(200); // Можно явно отвечать OK
    exit;
}

// Логирование для отладки
file_put_contents(
    __DIR__ . '/../storage/logs/webhook.log',
    print_r($data, true) . PHP_EOL . PHP_EOL,
    FILE_APPEND
);

