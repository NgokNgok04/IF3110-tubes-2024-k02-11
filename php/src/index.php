<?php
include('App/components/navbar.php');
require_once __DIR__ . '/autoload.php';


use App\Models\Users;

$users = new Users();
$allUsers = $users->getAllUsers();
print_r($allUsers);
