<?php

require_once 'vendor/autoload.php';

use app\Helpers\Env;

$dumpFile = __DIR__ . '/dump.sql';

if (!file_exists($dumpFile)) {
    die("Файл дампа не найден: $dumpFile\n");
}

try {
    $host = Env::get('DB_HOST');
    $db = Env::get('DB_DATABASE');
    $charset = Env::get('DB_CHARSET');

    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=$charset",
        Env::get('DB_USERNAME'),
        Env::get('DB_PASSWORD'),
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
        ]
    );
} catch (Exception $e) {
    die("Ошибка подключения: " . $e->getMessage() . "\n");
}

$sql = file_get_contents($dumpFile);
if ($sql === false) {
    die("Не удалось прочитать файл дампа: $dumpFile\n");
}

try {
    $pdo->exec($sql);
    echo "Дамп успешно импортирован!\n";
} catch (PDOException $e) {
    echo "Ошибка выполнения запроса: " . $e->getMessage() . "\n";
}