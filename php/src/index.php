<?php
require_once __DIR__ . '/autoload.php';

echo 'Hello World!';
echo '<script src="/public/index.js"></script>';


use App\Utils\Database;

$db = new Database();
$query = "SELECT * FROM users";
$result = $db->rowCount($query);
print_r("total data = " . $result . "\n");

$data = $db->fetchAll($query, []);
foreach ($data as $row) {
    print_r($row['email'] . "\n");
}
