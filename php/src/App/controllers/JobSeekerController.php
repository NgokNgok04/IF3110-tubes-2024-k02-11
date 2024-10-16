<?php

namespace App\Controllers;

use App\Core\Controller;

class JobSeekerController extends Controller
{
    public function riwayatPage()
    {
        $view = $this->view('JobSeeker', 'RiwayatView');
        $view->render();
    }
}