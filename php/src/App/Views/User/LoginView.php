<?php

namespace App\Views\User;
use App\Interfaces\ViewInterface;

class LoginView implements ViewInterface{
    public function render(){
        require_once PAGES_DIR . '/User/LoginPage.php'; 
    }
}