<?php
namespace app\components;

use app\Helpers\Env;
use Exception;
use PDO;
use PDOException;

class Database
{
    /**
     * @throws Exception
     */
    public static function connect(): PDO
    {
        $host = Env::get('DB_HOST', 'localhost');
        $db = Env::get('DB_NAME', 'shop');
        $username = Env::get('DB_USERNAME', 'root');
        $password = Env::get('DB_PASSWORD', '');
        $charset = Env::get('DB_CHARSET', 'utf8');

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
        return $pdo;
    }
}