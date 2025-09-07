<?php

namespace app\models;

use app\components\Database;

class Orders
{
    public static function add($data): bool
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            INSERT INTO orders (
                product_id,
                product_name,
                product_price,
                product_count,
                created_at,
                phone
            ) VALUES (
                :product_id,
                :product_name,
                :product_price,
                :product_count,
                :created_at,
                :phone
            )
        ");

        return $stmt->execute([
            'product_id'    => $data['product_id'],
            'product_name'  => $data['product_name'],
            'product_price' => $data['product_price'],
            'product_count' => $data['product_count'],
            'created_at'    => $data['created_at'],
            'phone'         => $data['phone'],
        ]);
        return $pdo->lastInserId();
    }
}
