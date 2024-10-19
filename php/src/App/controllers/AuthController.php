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
            $hashedPassword = hash('sha256',$_POST['password']);
            $isUserValid = $this->model->getUserByEmail($_POST['email']);
            if ($isUserValid && $isUserValid['password'] == $hashedPassword){
                $response['status'] = 'success';
                $_SESSION['role'] = 'jobseeker';
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
            if ($isUserRegistered || 
                $_POST['name'] == '' ||
                $_POST['email'] == '' || 
                (isset($_POST['role']) &&  $_POST['role'] != 'company' && $_POST['role'] != 'jobseeker') || 
                $_POST['password'] == '' ||
                ($_POST['role'] == 'company' && $_POST['location'] == '') ||
                ($_POST['role'] == 'company' && $_POST['about'] == '')
            ) {
                $response['status'] = 'error';
                $response['data'] = 'The email has been used';
            } else {
                if ($_POST['role'] == 'jobseeker'){
                    $this->model->addUser($_POST['name'],$_POST['email'],$_POST['role'],hash('sha256',$_POST['password']));
                } else if ($_POST['role'] == 'company'){
                    $this->model->addCompanyUser($_POST['name'],$_POST['email'],$_POST['role'],hash('sha256',$_POST['password']),$_POST['location'],$_POST['about']);
                }
                $response['status'] = 'success';
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
    }
}
