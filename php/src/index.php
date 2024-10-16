<?php

use App\Core\App;
// include('/App/components/navbar.php');
require_once __DIR__ . '/autoload.php';

$_SESSION['role'] = 'company';
$App = new App();
