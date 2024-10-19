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
        $user_id = $_SESSION['user_id'];
        $cv_path = $_FILES['cv']['full_path'];
        $video_path = $_FILES['video']['full_path'];
        $status = 'waiting';
        $created_at = date('Y-m-d H:i:s');
        // echo $lowongan_id; 
        // echo $user_id;
        // echo $cv;
        // echo $video;
        // echo $status;
        // echo $created_at;
        
        $this->model->addLamaran($user_id, $lowongan_id,$cv_path, $video_path, $status, "", $created_at);
        header('Location: /');
    }



    // debugging
    public function showDebug(){
        $lamarans = $this->model->getAllLamaran(); 
        $this->view('User', 'DebugPage', ['lamarans' => $lamarans]);
    }

}