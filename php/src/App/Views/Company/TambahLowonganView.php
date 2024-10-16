<?php

namespace App\Views\Company;
use App\Interfaces\ViewInterface;

class TambahLowonganView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/Company/TambahLowongan.php';
    }
}