<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../vendor/autoload.php";
use app\models\Orders;
use app\models\Products;
use app\components\Telegram;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Неверный метод запроса']);
    exit;
}

if (!isset($_POST['product_id'], $_POST['product_count'], $_POST['phone'])){
    echo json_encode(["error"=>"Не указаны обязательные поля"]);
    exit;
}

$product = Products::one($_POST['product_id']);
if (!$product){
    echo json_encode(["error"=>"Такого товара нет"]);
    exit;
}

$order = [
    'product_id'    => $product['id'],
    'product_name'  => $product['name'],
    'product_price' => $product['price'],
    'product_count' => (int)$_POST['product_count'],
    'created_at'    => date('Y-m-d H:i:s'),
    'phone'         => trim($_POST['phone']),
];

$order_id = Orders::add($order);

$message = 'Новый заказ #' . $order_id . PHP_EOL .
    'Товар: #' . $order['product_id'] . ' ' . $product['product_name'] . PHP_EOL .
    'Количество: ' . $order['product_count'] . PHP_EOL .
    'Цена: ' . $order['product_price'] . PHP_EOL .
    'Сумма: ' . ($order['product_count'] * $order['product_price']);
Telegram::sendMessage($message);
echo json_encode(['success' => 1]);