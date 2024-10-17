<?php

namespace App\Controllers;
use App\Core\Controller;

class LamaranController extends Controller
{
    // Page Untuk melamar ke lowongan tertentu
    public function lamaranPage($id)
    {
        $this->view('JobSeeker', 'Lamaran');
    }

    // Company bisa melihat lamaran tertentu
    public function detailLamaranPage($id)
    {
        $this->view('Company', 'DetailLamaran');
    }
}