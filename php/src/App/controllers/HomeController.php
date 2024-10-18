<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;
use App\Core\Database;
use App\Models\LowonganModel;

class HomeController extends Controller implements ControllerInterface
{
    private LowonganModel $modelLowongan;
    public function __construct()
    {
        $this->modelLowongan = $this->model('LowonganModel');
    }
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
        $lowonganList = $this->modelLowongan->getAllLowongan(); 
        $this->view('JobSeeker', 'HomeJobSeeker', ['lowonganList' => $lowonganList]);
    }

    public function companyHome(){
        $jobs = $this->modelLowongan->getAllLowongan();
        $this->view('Company', 'HomeCompany', ['jobs' => $jobs]);
    }
}
