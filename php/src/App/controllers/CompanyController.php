<?php

namespace App\Controllers;

use App\Core\Controller;

class CompanyController extends Controller
{
    public function profilePage()
    {
        $view = $this->view('Company', 'ProfilView');
        $view->render();
    }
}