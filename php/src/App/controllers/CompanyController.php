<?php

namespace App\Controllers;

use App\Core\Controller;

class CompanyController extends Controller
{
    public function profilePage()
    {
        $this->view('Company', 'ProfilView');
    }
}