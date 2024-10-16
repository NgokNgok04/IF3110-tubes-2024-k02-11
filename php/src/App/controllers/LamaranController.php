<?php

namespace App\Controllers;
use App\Core\Controller;

class LamaranController extends Controller
{
    // Page Untuk melamar ke lowongan tertentu
    public function lamaranPage($id)
    {
        $view = $this->view('JobSeeker', 'LamaranView');
        $view->render();
    }

    // Company bisa melihat lamaran tertentu
    public function detailLamaranPage($id)
    {
        $view = $this->view('Company', 'DetailLamaranView');
        $view->render();
    }
}