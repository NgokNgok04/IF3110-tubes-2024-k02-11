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
        $companyDetails = $this->model->getCompanyById($_SESSION['id']);
        $this->view('Company', 'CompanyProfile', [
            'companyDetails' => $companyDetails
        ]);
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $company_id = $_SESSION['id'];
            $company_name = trim($_POST['company_name']);
            $lokasi = trim($_POST['lokasi']);
            $about = trim($_POST['about']);

            $this->model->updateCompanyDetail($company_id, $company_name, $lokasi, $about);
            header("Location: /profil");
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['message' => 'Metode tidak diizinkan.']);
        }
    }


    //debug show 
    public function showDebug()
    {
        $companyDetails = $this->model->getAllCompany();
        $this->view('User', 'DebugPage', ['companyDetails' => $companyDetails]);
    }

}