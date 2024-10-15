<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;
class Home extends Controller implements ControllerInterface
{
    public function index()
    {
        $temp = $this->view('Company', 'CompanyView');
        $temp->render();
    }
}
