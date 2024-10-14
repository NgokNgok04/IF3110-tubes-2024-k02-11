<?php
use App\Core\App;

// include('/App/components/navbar.php');
require_once __DIR__ . '/autoload.php';


if(!session_id()) session_start();
$app = new App();