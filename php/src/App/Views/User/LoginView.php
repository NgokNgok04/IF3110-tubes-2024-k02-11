<?php

namespace App\Views\User;
use App\Interfaces\ViewInterface;

class LoginView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/User/LoginPage.php';
    }
}