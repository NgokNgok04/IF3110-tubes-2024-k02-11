<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;

class CompanyController extends Controller implements ControllerInterface
{
    public function index()
    {
        $temp = $this->view('Company', 'CompanyView');
        $temp->render();
    }
}