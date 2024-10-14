<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
class Home extends Controller
{
    public function index()
    {
        $this->view('TestView');
    }

    public function test(){
        echo "broh";
    }
}
