<?php

namespace App\Views\Company;
use App\Interfaces\ViewInterface;

class DetailLamaranView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/Company/DetailLamaran.php';
    }
}