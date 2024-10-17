<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AttachmentModel;

class AttachmentController extends Controller
{
    private AttachmentModel $model;

    public function __construct()
    {
        $this->model = $this->model('AttachmentModel');
    }
    public function profilePage()
    {
        $this->view('Company', 'CompanyProfile');
    }

    //debug show 
    public function showDebug(){
        $attachments = $this->model->getAllAttachment(); 
        $this->view('User', 'DebugPage', ['attachments' => $attachments]);
    }

}