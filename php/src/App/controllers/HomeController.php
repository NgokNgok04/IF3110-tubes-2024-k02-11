<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;
use App\Models\CompanyDetail;

class HomeController extends Controller implements ControllerInterface
{
    public function index()
    {
        $temp = $this->view('Home', 'HomeView');
        $temp->render();

        // $user = new CompanyDetail(); 
        // $user->addCompanyDetail(1, 1, 'PT. ABC', 'Jakarta', 'Perusahaan yang bergerak di bidang IT');
        // $temp = $user->getAllCompany();
        // var_dump($temp);
    }

    public function test(){
        $temp = $this->view('Test', 'TestView');
        $temp->render();
    }
}
