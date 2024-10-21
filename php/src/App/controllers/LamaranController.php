<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\LamaranModel;
use App\Models\UsersModel;

class LamaranController extends Controller
{
    private LamaranModel $model;
    private UsersModel $usersModel;
    // Page Untuk melamar ke lowongan tertentu

    public function __construct()
    {
        $this->model = $this->model('LamaranModel');
        $this->usersModel = $this->model('UsersModel');
    }
    public function lamaranPage($id)
    {
        $this->view('JobSeeker', 'Lamaran');
    }

    // Company bisa melihat lamaran tertentu
    public function detailLamaranPage($id)
    {
        $lamaran = $this->model->getLamaranById($id);
        $users = $this->usersModel->getUserById($lamaran['user_id']);
        $this->view('Company', 'DetailLamaran', [
            'lamaran' => $lamaran,
            'jobseeker' => $users,
        ]);
    }

    public function updateStatus($id)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $putData = json_decode(file_get_contents("php://input"), true);

            $status = $putData['status'] ?? null;
            $reason = $putData['status_reason'] ?? null;

            try {
                $this->model->updateStatus($id, $status, $reason);
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

    // debugging
    public function showDebug()
    {
        $lamarans = $this->model->getAllLamaran();
        $this->view('User', 'DebugPage', ['lamarans' => $lamarans]);
    }

}