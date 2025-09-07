<?php

$input = file_get_contents('php://input');
$data = json_decode($input, true);

file_put_contents(
    __DIR__ . '/../webhook.log',
    print_r($data, 1) . PHP_EOL . PHP_EOL,
    FILE_APPEND
);
