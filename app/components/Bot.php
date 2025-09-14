<?php
namespace app\components;

class Bot
{
    public static function processMessage($message)
    {

    }

    public static function processCallback($callback_query)
    {
$message_id = $callback_query['message']['message_id'];
$data = json_decode($callback_query['data'], true);

Telegram::answerCallbackQuery($callback_query['id']);
    }
}