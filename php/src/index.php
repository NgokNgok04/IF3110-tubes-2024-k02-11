<?php
require_once __DIR__ . '/autoload.php';

echo 'Hello World!';
echo '<script src="/public/index.js"></script>';


use App\Utils\Database;
use App\Models\Users;

// $db = new Database();
// $query = "SELECT * FROM users";
// $result = $db->rowCount($query);
// print_r("total data = " . $result . "\n");

$users = new Users();
$users->getAllUsers();

$users2 = new Users();
$users2->getAllUsers();

$users3 = new Users();
$users3->getAllUsers();