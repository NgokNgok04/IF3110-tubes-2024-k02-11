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

    public function showDebug(){
        
        $users = $this->model->getAllUsers(); // Adjust this based on your model

        // var_dump($users);
        // Pass users to the view
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
}