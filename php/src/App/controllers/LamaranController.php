<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\CompanyDetailModel;
use App\Models\LamaranModel;
use App\Models\LowonganModel;
use App\Models\UsersModel;

class LamaranController extends Controller
{
    private LamaranModel $model;
    // Page Untuk melamar ke lowongan tertentu

    public function __construct()
    {
        $this->model = $this->model('LamaranModel');
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
        $this->view('Company', 'DetailLamaran');
    }


    // Submit lamaran
    public function store($id)
    {
        // $user_id, $lowongan_id, $cv_path, $video_path, $status, $status_reason, $created_at
        $lowongan_id = $id;
        $user_id = $_SESSION['id'];
        $cv_path = '/var/www/upload/' . $_FILES['cv']['full_path'];
        $video_path = '/var/www/upload/' . $_FILES['video']['full_path'];
        $status = 'waiting';
        $created_at = date('Y-m-d H:i:s');
        $this->upload_cv();
        $this->upload_video();
        $this->model->addLamaran($user_id, $lowongan_id,$cv_path, $video_path, $status, "", $created_at);
        header('Location: /');   
    }

    public function upload_cv(){
        $target_dir = realpath( "/var/www/upload/");
        $target_file = $target_dir . "/" .basename($_FILES["cv"]["name"]);
        $uploadOK = 1; 
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if(file_exists($target_file)){
            echo "Sorry, file already exists.";
            $uploadOK = 0;
        }

        //allow pdf
        if($fileType != "pdf"){
            echo "Sorry, only PDF files are allowed.";
            $uploadOK = 0;
        }

        //size 
        if($_FILES["cv"]["size"] > 500000){
            echo "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        if($uploadOK == 0){
            echo "Sorry, your file was not uploaded.";
        } else {
            // echo $target_file;
            // echo $_FILES["cv"]["name"];
            // var_dump($_FILES["cv"]);
            if(move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file)){
                echo "The file ". htmlspecialchars(basename($_FILES["cv"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    public function upload_video() {
        $target_dir = realpath("/var/www/upload/");
        $target_file = $target_dir . "/" . basename($_FILES["video"]["name"]);
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
                echo "The video " . htmlspecialchars(basename($_FILES["video"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    


    // debugging
    public function showDebug(){
        $lamarans = $this->model->getAllLamaran(); 
        $this->view('User', 'DebugPage', ['lamarans' => $lamarans]);
    }

}