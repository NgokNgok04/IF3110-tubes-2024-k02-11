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
        $this->view('Company', 'TambahLowonganView');
    }

    public function editLowonganPage($id)
    {
        $this->view('Company', 'EditLowonganView');
    }


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
}