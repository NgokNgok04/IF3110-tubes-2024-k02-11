<?php

namespace App\Controllers;
use App\Interfaces\ControllerInterface;
use App\Core\Controller;
use App\Models\Users;

class UserController extends Controller implements ControllerInterface{
    private Users $model;
    public function __construct(){
        // TODO
        // $userRoleClass = 'App\\Models\\UsersRole';
        // require_once __DIR__ . '/../Models/UsersRole.php';
        $this->model = $this->model('Users'); //this->model tipe harus sesuai dengan nama file model
    }

    public function index(){
        // TODO
    }

    public function login(){
        // TODO
        $temp = $this->view('User', 'LoginView');
        $temp->render();
    }

    public function logout(){
        // TODO
    }

    public function register(){
        // TODO
    }
}