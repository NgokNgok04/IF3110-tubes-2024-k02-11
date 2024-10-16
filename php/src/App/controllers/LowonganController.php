<?php

namespace App\Controllers;
use App\Core\Controller;

class LowonganController extends Controller
{
    public function tambahLowonganPage()
    {
        $view = $this->view('Company', 'TambahLowonganView');
        $view->render();
    }

    public function editLowonganPage($id)
    {
        $view = $this->view('Company', 'EditLowonganView');
        $view->render();
    }


    public function detailLowonganPage($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] = 'company') {
            $view = $this->view('Company', 'DetailLowonganView');
        } else {
            $view = $this->view('JobSeeker', 'DetailLowonganView');
        }
        $view->render();
    }
}