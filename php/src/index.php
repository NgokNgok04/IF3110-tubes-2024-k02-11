<?php

use App\Core\App;
// include('/App/components/navbar.php');
require_once __DIR__ . '/autoload.php';

session_start();
$_SESSION['role'] = 'company';
$App = new App();
session_abort();