<?php

namespace App\Views\User;

use App\Core\View;
use App\Interfaces\ViewInterface;

class RegisterView implements ViewInterface{
    public function render(){
        require_once __DIR__ . '/../../Pages/User/RegisterPage.php';
    }
}