<?php

namespace App\Controllers;

use App\Core\Controller;

class JobSeekerController extends Controller
{
    public function riwayatPage()
    {
        $this->view('JobSeeker', 'Riwayat');
    }
}