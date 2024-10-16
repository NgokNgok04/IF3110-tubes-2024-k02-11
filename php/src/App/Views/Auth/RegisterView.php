<?php

namespace App\Views\Auth;
use App\Interfaces\ViewInterface;

class RegisterView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/Auth/RegisterPage.php';
    }
}