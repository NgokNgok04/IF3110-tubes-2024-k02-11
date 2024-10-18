<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\LamaranModel;

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
        $this->view('JobSeeker', 'Lamaran');
    }

    // Company bisa melihat lamaran tertentu
    public function detailLamaranPage($id)
    {
        $this->view('Company', 'DetailLamaran');
    }

    // debugging
    public function showDebug(){
        $lamarans = $this->model->getAllLamaran(); 
        $this->view('User', 'DebugPage', ['lamarans' => $lamarans]);
    }

}