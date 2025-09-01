<?php

namespace app\models;

use app\components\Database;

class Products
{
    public static function all()
    {
        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT * FROM products');
        return $stmt->fetchAll();
    }

    public static function one($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

}