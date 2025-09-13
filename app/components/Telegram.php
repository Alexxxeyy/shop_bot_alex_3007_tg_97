<?php
namespace app\components;

class Telegram
{
    const API_TOKEN = '8486389723:AAF1TgvepVaWIIljoh86SDixmKUGjIbO9VM';
    const CHAT_ID = 1945804086;
    public static function getInputData()
    {
        $input = file_get_contents('php://input');
        if ($input) {
            return json_decode($input, true);
        }
        return [];
    }

    public static function apiRequest($method, $params)
    {
        $url = 'https://api.telegram.org/bot' . self::API_TOKEN . '/' . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params)); // или просто $params
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $result = curl_exec($ch);
        if ($result === false) {
            error_log('cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($result, true);
    }

    public static function sendMessage($text, $keyboard=null)
    {
        $params = [
            'chat_id' => static::CHAT_ID,
            'text' => $text,
        ];
        if ($keyboard) {
            $reply_markup = [
                'inline_keyboard' => $keyboard,
            ];
            $params['reply_markup'] = json_encode($reply_markup);
        }

        static::apiRequest('sendMessage', $params);
    }
}