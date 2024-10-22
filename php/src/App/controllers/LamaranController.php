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
        $data = $this->model->getLamaranPage($id);
        $this->view('JobSeeker', 'Lamaran', [
            'data' => $data
        ]);

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


    // Submit lamaran
    public function store($id)
    {
        // $user_id, $lowongan_id, $cv_path, $video_path, $status, $status_reason, $created_at
        $lowongan_id = $id;
        $user_id = $_SESSION['id'];
        $cv_path = '/public/uploads/' . $_FILES['cv']['full_path'];
        $video_path = '/public/uploads/' . $_FILES['video']['full_path'];
        $status = 'waiting';
        $this->upload_cv();
        $this->upload_video();
        $this->model->addLamaran($user_id, $lowongan_id, $cv_path, $video_path, $status, "");
        header('Location: /');
    }

    public function upload_cv()
    {
        $target_dir = FILE_DIR;
        $target_file = $target_dir . "" . basename($_FILES["cv"]["name"]);
        $uploadOK = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOK = 0;
        }

        //allow pdf
        if ($fileType != "pdf") {
            echo "Sorry, only PDF files are allowed.";
            $uploadOK = 0;
        }

        //size 
        if ($_FILES["cv"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        if ($uploadOK == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // echo $target_file;
            // echo $_FILES["cv"]["name"];
            // var_dump($_FILES["cv"]);
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)) {
                // echo "The file ". htmlspecialchars(basename($_FILES["cv"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    public function upload_video()
    {
        $target_dir = FILE_DIR;
        $target_file = $target_dir . "" . basename($_FILES["video"]["name"]);
        $uploadOK = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed video formats (e.g., mp4, avi, mkv)
        $allowedTypes = ['mp4', 'avi', 'mkv', 'mov', 'webm'];

        // Check if the file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOK = 0;
        }

        // Check if the file type is allowed
        if (!in_array($fileType, $allowedTypes)) {
            echo "Sorry, only video files (MP4, AVI, MKV, MOV, WEBM) are allowed.";
            $uploadOK = 0;
        }

        // Check file size (limit: 500 MB)
        if ($_FILES["video"]["size"] > 500 * 1024 * 1024) { // 500 MB
            echo "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        if ($uploadOK == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
                // echo "The video " . htmlspecialchars(basename($_FILES["video"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }



    // debugging
    public function showDebug()
    {
        $lamarans = $this->model->getAllLamaran();
        $this->view('User', 'DebugPage', ['lamarans' => $lamarans]);
    }

}