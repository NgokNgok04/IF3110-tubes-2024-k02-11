<?php
require_once __DIR__ . '/autoload.php';

echo 'Hello World!';
echo '<script src="/public/index.js"></script>';


use App\Test\Test;
$test = new Test();
$test->test();