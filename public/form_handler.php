<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../vendor/autoload.php";
use app\models\Orders;
use app\models\Products;

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

$result = Orders::add($order);

if ($result === false) {
    echo json_encode(['error' => 'Ошибка сохранения заказа']);
    exit;
}

echo json_encode(['success' => 1]);