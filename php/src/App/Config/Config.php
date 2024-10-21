<?php

//ports
define('DB_PORT', value: $_ENV['POSTGRES_PORT']);

//directory
define('APP_DIR', __DIR__ . '/../');
define('FILE_DIR', '/var/www/html/public/uploads');

define('BASE_URL', 'http://localhost:8000/');
define('CSS', __DIR__ . '/../../public/styles');

define('PAGES_DIR', __DIR__ . '/../Pages');
//database
define('DB_HOST', value: $_ENV['POSTGRES_HOST']);
define('DB_NAME', value: $_ENV['POSTGRES_DB']);
define('DB_USER', value: $_ENV['POSTGRES_USER']);
define('DB_PASSWORD', value: $_ENV['POSTGRES_PASSWORD']);