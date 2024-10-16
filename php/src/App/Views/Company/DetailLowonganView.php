<?php

namespace App\Views\Company;
use App\Interfaces\ViewInterface;

class DetailLowonganView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/Company/DetailLowongan.php';
    }
}