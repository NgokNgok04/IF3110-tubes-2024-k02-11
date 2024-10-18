<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\CompanyDetailModel;
use App\Models\LowonganModel;
use App\Models\AttachmentModel;
use App\Models\LamaranModel;

class LowonganController extends Controller
{
    private LowonganModel $model;
    private CompanyDetailModel $companyModel;
    private AttachmentModel $attachmentModel;
    private LamaranModel $lamaranModel;

    public function __construct()
    {
        $this->model = $this->model('LowonganModel');
        $this->companyModel = $this->model('CompanyDetailModel');
        $this->attachmentModel = $this->model('AttachmentModel');
        $this->lamaranModel = $this->model('LamaranModel');
    }

    public function tambahLowonganPage()
    {
        $this->view('Company', 'TambahLowongan');
    }

    public function editLowonganPage($id)
    {
        $this->view('Company', 'EditLowonganView');
    }


    //detail lowongan Page
    public function detailLowonganPage($id)
    {
        // echo $_SESSION['role'];
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            // echo "masuk sini";
            $this->view('Company', 'DetailLowongan');
        } else {
            $dataDetail= $this->model->getLowonganByID($id);
            $dataCompany = $this->companyModel->getCompanyById($dataDetail['company_id']);
            $dataAttachment = $this->attachmentModel->getAttachmentByLowonganId($id);
            $dataLamaran = $this->lamaranModel->getLamaranByLowonganId($id);
            // $company = $this->companyModel->getCompanyById($lowongan['company_id']);
            $this->view('JobSeeker', 'DetailLowongan', [
                'lowongan' => $dataDetail, 
                'company' => $dataCompany,
                'attachment' => $dataAttachment,
                'lamaran' => $dataLamaran
            ]);
        }
    }

    public function showDebug(){
        $lowongans = $this->model->getAllLowongan(); 
        $this->view('User', 'DebugPage', ['lowongans' => $lowongans]);
        //TODO
    }


    public function storeLowongan()
    {
        $posisi = $_POST['title'];
        $description = $_POST['description'];
        $requirements = $_POST['requirements'];
        $location = $_POST['location'];

        if(!isset($_SESSION['company_id'])){
            header('Location: /tambah-lowongan');
        }
        $company_id = $_SESSION['company_id'];
        $is_open = True; 
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        // echo $company_id;
        // echo $posisi;
        // echo $description;
        // echo $requirements;
        // echo $location;
        // echo $is_open;
        // echo $created_at;
        // echo $updated_at;

        $result = $this->model->addLowongan( $company_id, $posisi, $description, $requirements, $location, $is_open, $created_at, $updated_at);
        if (!$result) {
            header('Location: /tambah-lowongan');
        } else {
            header('Location: /');
        }

        // Redirect
        header('Location: /');
    }
}