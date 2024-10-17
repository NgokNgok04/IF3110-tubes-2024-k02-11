<?php

namespace App\Controllers;
use App\Core\Controller; 
use App\Models\UsersModel;
use App\Core\Database;


class UserController extends Controller{
    private UsersModel $model;

    public function __construct(){
        $this->model = $this->model('UsersModel');
    }

    public function debug(){
        $this->view('User', 'DebugPage'); 
    }

    //debugging SECTION

    public function showDebug(){
        $users = $this->model->getAllUsers(); 
        $this->view('User', 'DebugPage', ['users' => $users]);
        //TODO
    }

    public function deleteDB(){
        $db = Database::getInstance();
        $db->runScript(APP_DIR . '../db/reset.sql');
        $this->view('User', 'DebugPage');
    }

    public function createDB(){
        $db = Database::getInstance();
        $db->runScript(APP_DIR . '../db/init.sql');
        $this->view('User', 'DebugPage');
    }

    public function seeding(){
        $db = Database::getInstance();
        $db->runScript(APP_DIR . '../db/seeding.sql');
        $this->view('User', 'DebugPage');
    }
}