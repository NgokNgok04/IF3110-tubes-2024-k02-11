<?php

namespace App\Views\User;

use App\Core\View;
use App\Interfaces\ViewInterface;

class RegisterView implements ViewInterface{
    public function render(){
        require_once PAGES_DIR . '/User/RegisterPage.php';
    }
}
                // Hash the password for security