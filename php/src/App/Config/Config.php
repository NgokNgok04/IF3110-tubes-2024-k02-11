<?php

//env access
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        throw new Exception("The .env file does not exist.");
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        if (!array_key_exists($key, $_ENV)) {
            $_ENV[$key] = $value;
        }
    }
}
loadEnv(__DIR__  . '/.env');

//ports
define('DB_PORT', value: $_ENV['POSTGRES_PORT']);


//directory
define('APP_DIR', __DIR__ . '/../');

//database
define('DB_HOST', value: $_ENV['POSTGRES_HOST']);
define('DB_NAME', value: $_ENV['POSTGRES_DB']);
define('DB_USER', value: $_ENV['POSTGRES_USER']);
define('DB_PASSWORD', value: $_ENV['POSTGRES_PASSWORD']);