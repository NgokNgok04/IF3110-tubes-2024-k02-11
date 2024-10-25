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
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            // $hashedPassword = hash('sha256',$_POST['password']);
            $isUserValid = $this->model->getUserByEmail($_POST['email']);
            if ($isUserValid && $isUserValid['password'] == $_POST['password']){
                $_SESSION['role'] = $isUserValid['role'];
                $_SESSION['id'] = $isUserValid['user_id'];
                $_SESSION['name'] = $isUserValid['nama'];
                $_SESSION['success_message'] = 'Login Sucessfull';
                $response['status'] = 'success';
                // $response['data'] = 'Login success';
            } else {
                $response['status'] = 'error';
                $response['data'] = 'Email or password wrong';
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $isUserRegistered = $this->model->getUserByEmail($_POST['email']);
            $response = [];
            error_log("HASEMELEH");
            if ($isUserRegistered)
            {
                $response['status'] = 'error';
                $response['data'] = 'The email has been used';
            } else {
                if ($_POST['role'] == 'company'){
                    $this->model->addCompanyUser($_POST['name'],$_POST['email'],$_POST['role'],hash('sha256',$_POST['password']),$_POST['location'],$_POST['about']);
                } else if ($_POST['role'] == 'jobseeker'){
                    $this->model->addUser($_POST['name'],$_POST['email'],$_POST['role'],hash('sha256',$_POST['password']));
                }
                $response['status'] = 'success';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }

    public function logout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            unset($_SESSION['role']);
            unset($_SESSION['id']);
            session_destroy();
            // echo $_SESSION['role']; 
            // echo $_SESSION['id'];
        }
            header('Content-Type: application/json');
            echo json_encode((['status' => 'success']));
        exit();
    }
}
