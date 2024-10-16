<?php
use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\LowonganController;
use App\Controllers\LamaranController;
use App\Controllers\CompanyController;
use App\Controllers\JobSeekerController;

// include('/App/components/navbar.php');
require_once __DIR__ . '/autoload.php';

$router = new Router();
$_SESSION['role'] = 'company';
// Routes accessible to all roles (unauthorized, jobseeker, company)
$router->get('/login', AuthController::class, 'loginPage');
$router->get('/register', AuthController::class, 'registerPage');
$router->get('/', HomeController::class, 'index');
$router->get('/detail-lowongan/{id}', LowonganController::class, 'detailLowonganPage', ['company', 'jobseeker']);

// Routes for 'company' role
$router->get('/tambah-lowongan', LowonganController::class, 'tambahLowonganPage', ['company']);
$router->get('/detail-lamaran/{id}', LamaranController::class, 'detailLamaranPage', ['company']);
$router->get('/edit-lowongan/{id}', LowonganController::class, 'editLowonganPage', ['company']);
$router->get('/profil', CompanyController::class, 'profilePage', ['company']);

$router->post('/tambah-lowongan', LowonganController::class, 'store', ['company']);
$router->post('/edit-lowongan/{id}', LowonganController::class, 'update', ['company']);

// Routes for 'jobseeker' role
$router->get('/lamaran/{id}', LamaranController::class, 'lamaranPage', ['jobseeker']);
$router->get('/riwayat', JobSeekerController::class, 'riwayatPage', ['jobseeker']);

$router->post('/lamaran/{id}', LamaranController::class, 'submit', ['jobseeker']);

// Dispatch the route
$router->dispatch();
