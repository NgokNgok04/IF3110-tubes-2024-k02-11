<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
class Home extends Controller
{
    public function index()
    {
        // $this->view('TestView');
        $db = new Database(); 
        $table = $db->fetchAll('SELECT * FROM users');
        print_r($table);
    }

    public function broh(){
        echo "broh";
    }
}
