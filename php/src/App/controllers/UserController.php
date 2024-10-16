<?php

namespace App\Controllers;
use App\Core\Controller; 
use App\Models\Users;

class UserController extends Controller{
    public function debug(){
        $view = $this->view('User', 'DebugView'); 
        $view->render();
    }

    public function showDebug(){
        
        $userModel = new Users();
        $users = $userModel->getAllUsers(); // Adjust this based on your model

        // var_dump($users);
        // Pass users to the view
        $view = $this->view('User', 'DebugView', ['users' => $users]);
        $view->render();
        //TODO

    }

}