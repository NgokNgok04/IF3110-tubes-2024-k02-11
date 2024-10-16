<?php

namespace App\Views\Company;
use App\Interfaces\ViewInterface;

class HomeCompanyView implements ViewInterface
{
    public function render()
    {
        require_once __DIR__ . '/../../Pages/Company/HomeCompany.php';
    }
}