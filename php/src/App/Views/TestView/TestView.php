<?php

namespace App\Views;

use App\Interfaces\ViewInterface;

class TestView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../Pages/TestPage.php';
    }
}