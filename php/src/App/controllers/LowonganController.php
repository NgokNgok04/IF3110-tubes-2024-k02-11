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
        $lowongan = $this->model->getLowonganByID(($id));
        $this->view('Company', 'EditLowongan', [
            'lowongan' => $lowongan,
        ]);

    }


    //detail lowongan Page
    public function detailLowonganPage($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            $lowongan = $this->model->getLowonganByID(($id));
            $listLamaran = $this->lamaranModel->getLamaranStatusAndNamaBYLowonganID($id);
            $this->view('Company', 'DetailLowongan', [
                'lowongan' => $lowongan,
                'listLamaran' => $listLamaran
            ]);
        } else {
            $dataDetail = $this->model->getLowonganByID($id);
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

    public function deleteLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $isDeleted = $this->model->deleteLowonganByID($id);

            if ($isDeleted) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Lowongan berhasil dihapus']);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus lowongan']);
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan']);
        }
    }

    public function toogleLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $isToogled = $this->model->toogleIsOpen($id);

            if ($isToogled) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Lowongan berhasil ditutup']);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['status' => 'error', 'message' => 'Gagal menutup lowongan']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['message' => 'Metode tidak diizinkan.']);
        }
    }


    public function updateLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $posisi = $_POST['posisi'] ?? null;
            $deskripsi = $_POST['deskripsi'] ?? null;
            $jenis_pekerjaan = $_POST['jenis_pekerjaan'] ?? null;
            $jenis_lokasi = $_POST['jenis_lokasi'] ?? null;
            $is_open = $_POST['is_open'];
            $is_open === 'true' ? true : false;

            try {
                $this->model->updateLowongan($id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $is_open);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update lowongan: ' . $e->getMessage()]);
                return;
            }

            http_response_code(200);
            echo json_encode(['message' => 'Lowongan berhasil diperbarui']);
        } else {
            http_response_code(405); 
            echo json_encode(['message' => 'Metode tidak diizinkan.']);
        }
    }


    public function showDebug()
    {
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

        if (!isset($_SESSION['company_id'])) {
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

        $result = $this->model->addLowongan($company_id, $posisi, $description, $requirements, $location, $is_open, $created_at, $updated_at);
        if (!$result) {
            header('Location: /tambah-lowongan');
        } else {
            header('Location: /');
        }

        // Redirect
        header('Location: /');
    }
}