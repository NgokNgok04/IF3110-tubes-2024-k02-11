<?php

// namespace App\Controllers;
// use App\Interfaces\ControllerInterface;
// use App\Core\Controller;
// use App\Models\Users;
// use App\Views\User\DebugView;

// class UserController extends Controller implements ControllerInterface{
//     private Users $model;
//     public function __construct(){
//         // TODO
//         // $userRoleClass = 'App\\Models\\UsersRole';
//         // require_once __DIR__ . '/../Models/UsersRole.php';
//         $this->model = $this->model('Users'); //this->model tipe harus sesuai dengan nama file model
//     }

//     public function index(){
//         // TODO
//     }

//     public function loginPage(){
//         $temp = $this->view('User', 'LoginView');
//         $temp->render();
//         // TODO
//     }

//     public function logoutPage(){
//         // TODO
//     }

//     public function registerPage(){
//         $pageView = $this->view('User', 'RegisterView');
//         $pageView->render();
//         // TODO
//     }

    
//     public function register() {
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             // Retrieve submitted data
//             $username = $_POST['username'] ?? '';
//             $password = $_POST['password'] ?? '';
//             $type = $_POST['type'] ?? '';
//             $email = $_POST['email'] ?? '';
            
//             echo "Password: $password";
//             echo "Username: $username";
//             echo "Type: $type";
//             echo "Email: $email";
            
//             // check in database if username already exists
//             $user = $this->model->getUserByUsername($username);
//             if ($user) {
//                 echo "Username already exists";
//             } else {
//                 // add user to database
//                 $this->model->addUser($username, $email, $type, $password);
//                 echo "User added";
//             }
//         }
//     }

//     // debug section
//     public function DebugUser() {
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $users = $this->model->getAllUsers();
//             $_SESSION['flash']['users'] = $users;
//             header('Location: /user/DebugPage');
//             exit();
//         }
//     }
    
//     public function DebugPage() {
//         $users = $_SESSION['flash']['users'] ?? [];
//         unset($_SESSION['flash']['users']);
//         $pageView = new DebugView('users', ['users' => $users]);
//         $pageView->render();
//     }
    
// }