<?php

namespace app\models;

use app\components\Database;

class Orders
{
    /**
     * Добавляет новый заказ и возвращает ID добавленной записи в случае успеха, либо false в случае ошибки.
     */
    public static function add($data)
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

        $ok = $stmt->execute([
            'product_id'    => $data['product_id'],
            'product_name'  => $data['product_name'],
            'product_price' => $data['product_price'],
            'product_count' => $data['product_count'],
            'created_at'    => $data['created_at'],
            'phone'         => $data['phone'],
        ]);

        if ($ok) {
            return $pdo->lastInsertId(); // Возвращаем id вставленной строки
        } else {
            return false; // В случае ошибки
        }
    }
}
