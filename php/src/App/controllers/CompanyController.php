<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CompanyDetailModel;

class CompanyController extends Controller
{
    private CompanyDetailModel $model;

    public function __construct()
    {
        $this->model = $this->model('CompanyDetailModel');
    }
    public function profilePage()
    {
        $this->view('Company', 'CompanyProfile');
    }

    //debug show 
    public function showDebug(){
        $companyDetails = $this->model->getAllCompany(); 
        $this->view('User', 'DebugPage', ['companyDetails' => $companyDetails]);
    }

}