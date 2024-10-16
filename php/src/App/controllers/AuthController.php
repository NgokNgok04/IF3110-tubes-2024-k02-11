<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Users;

class AuthController extends Controller
{
    private Users $model;
    public function __construct()
    {
        // TODO
        // $userRoleClass = 'App\\Models\\UsersRole';
        // require_once __DIR__ . '/../Models/UsersRole.php';
        $this->model = $this->model('Users'); //this->model tipe harus sesuai dengan nama file model
    }
    public function loginPage()
    {
        $view = $this->view('Auth', 'LoginView');
        $view->render();
    }

    public function registerPage()
    {
        $view = $this->view('Auth', 'RegisterView');
        $view->render();
    }

    public function login() {
        if ($_POST['submit']){
            $hashedPassword = hash('sha256',$_POST['password']);
            $isUserValid = $this->model->getUserByEmail($_POST['email']);
            if ($isUserValid && $isUserValid['password'] == $hashedPassword){
                $_SESSION['role'] = $isUserValid['role'];
                header("Location: /", true, 301);
            } else {
                echo $_POST['email'] . "<br>";
                echo $_POST['password'] . "<br>";
                echo "salah woi";
            }
        }
    }

    public function register() {
        if ($_POST['submit']){
            $isUserRegistered = $this->model->getUserByEmail($_POST['email']);
            if ($isUserRegistered) {
                // modal wrong
                echo "salah";
            } else {
                $this->model->addUser($_POST['name'],$_POST['email'],$_POST['role'],hash('sha256',$_POST['password']));
                echo "berhasil ditambahkan";
                $all = $this->model->getAllUsers();
            }
        }
    }
}
