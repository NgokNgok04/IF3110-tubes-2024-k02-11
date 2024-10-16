<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;

class HomeController extends Controller implements ControllerInterface
{
    public function index()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            $this->companyHome();

        } else {
            $this->jobSeekerHome();
        }
    }

    private function jobSeekerHome()
    {
        $view = $this->view('JobSeeker', 'HomeJobSeekerView');
        $view->render();
    }

    private function companyHome()
    {
        $view = $this->view('Company', 'HomeCompanyView');
        $view->render();
    }
}
