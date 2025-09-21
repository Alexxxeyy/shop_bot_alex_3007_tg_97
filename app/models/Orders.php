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
            return $pdo->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Переключает статус заказа и возвращает новое значение статуса (0 или 1) в случае успеха.
     */
    public static function toggleStatus($id)
    {
        $pdo = Database::connect();

        // Получаем текущий статус
        $stmt = $pdo->prepare('SELECT status FROM orders WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if ($row) {
            $status = $row['status'] ? 0 : 1;

            // Обновляем статус
            $stmt = $pdo->prepare('UPDATE orders SET status = :status, modified_at = :modified_at WHERE id = :id');
            $stmt->execute([
                'status'      => $status,
                'id'          => $id,
                'modified_at' => date('Y-m-d H:i:s'),
            ]);
            return $status;
        } else {
            return false; // Если заказа с таким ID нет
        }
    }

    public static function delete(mixed $id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('delete from orders where id = :id');
        $stmt->execute(['id'=>$id]);
    }
}