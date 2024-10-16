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
        $view = $this->view('User', 'DebugView'); 
        $view->render();
    }

    public function showDebug(){
        
        $users = $this->model->getAllUsers(); // Adjust this based on your model

        // var_dump($users);
        // Pass users to the view
        $view = $this->view('User', 'DebugView', ['users' => $users]);
        $view->render();
        //TODO

    }

}