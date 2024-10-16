<?php

namespace App\Controllers;
use App\Core\Controller; 
use App\Models\UsersModel;

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

}