<?php
namespace app\components;

use app\models\Orders;
// use app\components\Telegram; // Раскомментируйте и укажите путь, если Telegram — ваш отдельный компонент

class Bot
{
    public static function processMessage($message)
    {
        // Логика обработки сообщений (если требуется)
    }

    public static function processCallback($callback_query)
    {
        // Проверка наличия нужных ключей
        if (
            !isset($callback_query['message']['message_id']) ||
            !isset($callback_query['data']) ||
            !isset($callback_query['id'])
        ) {
            exit;
        }

        $message_id = $callback_query['message']['message_id'];
        $data = json_decode($callback_query['data'], true);

        if (!is_array($data) || !isset($data['command'])) {
            exit;
        }

        // Предполагается, что Telegram::answerCallbackQuery() объявлен и доступен
        Telegram::answerCallbackQuery($callback_query['id']);

        switch ($data['command']) {
            case 'toggle_order_status':
                if (!isset($data['id'])) {
                    exit;
                }
                $status = Orders::toggleStatus($data['id']);
                $keyboard = static::getOrderKeyboard($data['id'], $status);
                $chat_id = $callback_query['message']['chat']['id'];
                Telegram::editMessageKeyboard($chat_id, $message_id, $keyboard);
                break;
            // Добавьте другие case, если нужно
        }
    }

    public static function getOrderKeyboard($order_id, $status)
    {
        $status_str = $status ? 'Выполнен' : 'Новый';
        return [
            [
                [
                    'text' => $status_str,
                    'callback_data' => json_encode([
                        'command' => 'toggle_order_status',
                        'id' => $order_id
                    ])
                ],
                [
                    'text' => 'Удалить',
                    'callback_data' => json_encode([
                        'command' => 'delete_order',
                        'id' => $order_id
                    ])
                ]
            ]
        ];
    }
}