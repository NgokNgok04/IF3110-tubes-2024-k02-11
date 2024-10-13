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

$result = $users->addUser('test', 'broh@capek.com', 'jobseeker','123456');
if($result) echo "Success add user\n";
else echo "Failed add user\n";

$result = $users->getAllUsers();
print_r($result);