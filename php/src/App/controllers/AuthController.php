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

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve submitted data
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $type = $_POST['type'] ?? '';
            $email = $_POST['email'] ?? '';

            echo "Password: $password";
            echo "Username: $username";
            echo "Type: $type";
            echo "Email: $email";

            // check in database if username already exists
            $user = $this->model->getUserByUsername($username);
            if ($user) {
                echo "Username already exists";
            } else {
                // add user to database
                $this->model->addUser($username, $email, $type, $password);
                echo "User added";
            }
        }
    }
}
