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
        $company_id = $this->model->getCompanyFromLamaran($id);
        if ($company_id != $_SESSION['id']) {
            $this->view('Error', 'NoAccess');
            exit;
        }
        $data = $this->model->getLamaranPage($id);
        $this->view('JobSeeker', 'Lamaran', [
            'data' => $data
        ]);
    }

    // Company bisa melihat lamaran tertentu
    public function detailLamaranPage($id)
    {
        $company_id = $this->model->getCompanyFromLamaran($id);
        if ($company_id != $_SESSION['id']) {
            $this->view('Error', 'NoAccess');
            exit;
        }

        $lamaran = $this->model->getLamaranById($id);
        $users = $this->usersModel->getUserById($lamaran['user_id']);
        $this->view('Company', 'DetailLamaran', [
            'lamaran' => $lamaran,
            'jobseeker' => $users,
        ]);
    }

    public function updateStatus($id)
    {
        $company_id = $this->model->getCompanyFromLamaran($id);
        if ($company_id != $_SESSION['id']) {
            http_response_code(403);
            echo json_encode(['message' => 'THIS IS NOT YOUR JOB POST!!!']);
            header('Location: /');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $putData = json_decode(file_get_contents("php://input"), true);

            $status = $putData['status'] ?? null;
            $reason = $putData['status_reason'] ?? null;

            try {
                $this->model->updateStatus($id, $status, $reason);
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['message' => 'Failed to update Application: ' . $e->getMessage()]);
                return;
            }

            http_response_code(200);
            echo json_encode(['message' => 'Application Updated']);
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed.']);
        }
    }

    // Submit lamaran
    public function store($id)
    {
        $lowongan_id = $id;
        $user_id = $_SESSION['id'];
        if (isset($_FILES['cv']) && $_FILES['cv']['name'] != '') {
            $cv_path = '/public/uploads/' . pathinfo($_FILES['cv']['name'], PATHINFO_FILENAME) . '-' . $user_id . '-' . $lowongan_id . '.pdf';
        }
        if (isset($_FILES['video']) && $_FILES['video']['name'] != '') {
            $video_path = '/public/uploads/' . pathinfo($_FILES['video']['name'], PATHINFO_FILENAME) . '-' . $user_id . '-' . $lowongan_id . '.' . pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        } else {
            $video_path = null;
        }

        $cv_uploaded = false;
        $video_uploaded = false;
        if (isset($cv_path) && isset($_FILES['cv']) && $_FILES['cv']['name'] != '') {
            $cv_uploaded = $this->uploadFile($lowongan_id, $_FILES['cv'], ['pdf'], 100 * 1024 * 1024);
        }
        if (isset($video_path) && isset($_FILES['video']) && $_FILES['video']['name'] != '') {
            $video_uploaded = $this->uploadFile($lowongan_id, $_FILES['video'], ['mp4', 'avi', 'mkv', 'mov', 'webm'], 100 * 1024 * 1024);
        }
        if ($cv_uploaded || (isset($video_uploaded) && $video_uploaded)) {
            $status = 'waiting';
            $result = $this->model->addLamaran($user_id, $lowongan_id, $cv_path, $video_path, $status, "");

            if ($result) {
                $_SESSION['success_message'] = 'Lamaran berhasil dikirim';
                header("Location: /detail-lowongan/$lowongan_id?status=success");
            } else {
                $_SESSION['error_message'] = 'Gagal mengirim lamaran';
                header("Location: /detail-lowongan/$lowongan_id?status=failed");
            }
        } else {
            $_SESSION['error_message'] = 'Gagal mengunggah file';
            header("Location: /detail-lowongan/$lowongan_id?status=failed");
        }
    }




    public function uploadFile($lowongan_id, $file, $allowedTypes, $maxSize, )
    {
        $target_dir = FILE_DIR;

        // Generate a new filename: original_name-user_id.extension
        $filename = pathinfo($file["name"], PATHINFO_FILENAME) . '-' . $_SESSION['id'] . '-' . $lowongan_id;
        $extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $new_file_name = $filename . '.' . $extension;
        $target_file = $target_dir . $new_file_name;
        $uploadOK = 1;

        // Check if the file already exists
        if (file_exists($target_file)) {
            $uploadOK = 0;
        }

        // Validate file type
        if (!in_array($extension, $allowedTypes)) {
            $uploadOK = 0;
        }

        // Validate file size
        if ($file["size"] > $maxSize) {
            header("Location: /detail-lowongan/$lowongan_id?status=too-large");
            $uploadOK = 0;
        }

        // Attempt to upload the file
        if ($uploadOK == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return true;
            } else {
                header("Location: /detail-lowongan/$lowongan_id?status=failed");
            }
        }
        return false;
    }
    // debugging
    public function showDebug()
    {
        $lamarans = $this->model->getAllLamaran();
        $this->view('User', 'DebugPage', ['lamarans' => $lamarans]);
    }
}