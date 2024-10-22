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
        $lowongan_id = $id;
        $user_id = $_SESSION['id'];

        // Define the new file paths
        $cv_path = '/public/uploads/' . pathinfo($_FILES['cv']['name'], PATHINFO_FILENAME) . '-' . $user_id . '-' . $lowongan_id . '.pdf';
        $video_path = '/public/uploads/' . pathinfo($_FILES['video']['name'], PATHINFO_FILENAME) . '-' . $user_id . '-' . $lowongan_id . '.' . pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
        $status = 'waiting';

        // Add to database
        $result = $this->model->addLamaran($user_id, $lowongan_id, $cv_path, $video_path, $status, "");

        if ($result) {
            $cv_uploaded = $this->uploadFile($lowongan_id, $_FILES['cv'], ['pdf'], 100 * 1024 * 1024);
            $video_uploaded = $this->uploadFile($lowongan_id, $_FILES['video'], ['mp4', 'avi', 'mkv', 'mov', 'webm'], 100 * 1024 * 1024);

            if ($cv_uploaded && $video_uploaded) {
                header('Location: /');
            } else {
                echo "Failed to upload one or more files.";
            }
        } else {
            echo "Failed to submit lamaran.";
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
            echo "Sorry, file already exists.";
            $uploadOK = 0;
        }

        // Validate file type
        if (!in_array($extension, $allowedTypes)) {
            echo "Sorry, only " . implode(", ", $allowedTypes) . " files are allowed.";
            $uploadOK = 0;
        }

        // Validate file size
        if ($file["size"] > $maxSize) {
            echo "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        // Attempt to upload the file
        if ($uploadOK == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return true;
            } else {
                echo "Sorry, there was an error uploading " . htmlspecialchars($new_file_name) . ".";
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