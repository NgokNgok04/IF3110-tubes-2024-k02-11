<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\UsersModel;

class AuthController extends Controller
{
    private UsersModel $model;
    public function __construct()
    {
        // TODO
        // $userRoleClass = 'App\\Models\\UsersRole';
        // require_once __DIR__ . '/../Models/UsersRole.php';
        $this->model = $this->model('UsersModel'); //this->model tipe harus sesuai dengan nama file model
    }
    public function loginPage()
    {
        $this->view('Auth', 'LoginPage');
        // $view->render();
    }

    public function registerPage()
    {
        $this->view('Auth', 'RegisterPage');
    }

    public function login() {
        if (isset($_POST['submit'])){
            $hashedPassword = hash('sha256',$_POST['password']);
            $isUserValid = $this->model->getUserByEmail($_POST['email']);
            if ($isUserValid && $isUserValid['password'] == $hashedPassword){
                $_SESSION['role'] = $isUserValid['role'];
                echo $isUserValid['role'];
                // header("Location: /");
                // echo $_SESSION['role'];
            } else {
                echo $_POST['email'] . "<br>";
                echo $_POST['password'] . "<br>";
                echo "salah woi";
            }
        }
    }

    public function register() {
        if (isset($_POST['submit'])){
            // echo "masuk sini lalala";
            $isUserRegistered = $this->model->getUserByEmail($_POST['email']);
            if ($isUserRegistered) {
                $_SESSION['register_error'] = 'Username already taken';
                $_SESSION['register_data'] = $_POST;
                // $this->registerPage();
                header("Location: /register");
                echo "alert('test wahyudi')";
                // exit();
            } else {
                $this->model->addUser($_POST['name'],$_POST['email'],$_POST['role'],hash('sha256',$_POST['password']));
                header("Location: /",true,301);
            }
        }
    }
}
