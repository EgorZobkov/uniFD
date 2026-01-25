<?php

$envPath = BASE_PATH . '/.env';

if (is_readable($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }

        $key = trim($parts[0]);
        $value = trim($parts[1]);
        $value = trim($value, "\"'");

        if ($key === '') {
            continue;
        }

        if (getenv($key) === false) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }
    }
}

$env = static function (string $key, $default = null) {
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }

    return $value;
};

return [
    "driver" => $env('DB_DRIVER', 'mysql'),
    "charset" => $env('DB_CHARSET', 'utf8'),
    "port" => $env('DB_PORT', '3306'),
    "host" => $env('DB_HOST', 'localhost'),
    "database" => $env('DB_NAME', 'change_me'),
    "user" => $env('DB_USER', 'change_me'),
    "password" => $env('DB_PASS', 'change_me'),
];