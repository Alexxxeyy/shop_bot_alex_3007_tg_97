<?php

namespace app\Helpers;

use Exception;

class Env
{
    protected static array $variables = [];

    protected static bool $loaded = false;

    /**
     * @throws Exception
     */
    public static function load(string $path = __DIR__ . '/../../.env'): void
    {
        if (! file_exists($path)) {
            throw new Exception("Файл .env не найден: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Пропускаем комментарии
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            [$name, $value] = array_map('trim', explode('=', $line, 2));

            $value = trim($value, "\"'");

            self::$variables[$name] = $value;
            $_ENV[$name] = $value;
            putenv("{$name}={$value}");
        }

        self::$loaded = true;
    }

    /**
     * @throws Exception
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        if (! self::$loaded) {
            self::load();
        }

        return self::$variables[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
    }
}