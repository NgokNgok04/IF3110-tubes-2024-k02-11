<?php

namespace App\Core;

use App\Controllers\AttachmentController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\LowonganController;
use App\Controllers\LamaranController;
use App\Controllers\CompanyController;
use App\Controllers\JobSeekerController;
use App\Controllers\UserController;
use App\Core\Database;

class App
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->defineRoutes();
        $this->router->dispatch();
    }

    private function defineRoutes()
    {
        $this->router->get('/login', AuthController::class, 'loginPage');
        $this->router->get('/register', AuthController::class, 'registerPage');

        $this->router->get('/', HomeController::class, 'index');



        $this->router->get('/detail-lowongan/{id}', LowonganController::class, 'detailLowonganPage', ['company', 'jobseeker']);
        
        $this->router->post('/login', AuthController::class, 'login');
        $this->router->post('/register', AuthController::class, 'register');

        // Routes for 'company' role
        $this->router->get('/tambah-lowongan', LowonganController::class, 'tambahLowonganPage', ['company']);
        $this-> router->get('/detail-lamaran/{id}', LamaranController::class, 'detailLamaranPage', ['company']);
        $this->router->get('/edit-lowongan/{id}', LowonganController::class, 'editLowonganPage', ['company']);
        $this->router->get('/profil', CompanyController::class, 'profilePage', ['company']);
        

        $this->router->post('/tambah-lowongan', LowonganController::class, 'store', ['company']);
        $this->router->post('/edit-lowongan/{id}', LowonganController::class, 'update', ['company']);
        
        // Routes for 'jobseeker' role
        $this->router->get('/lamaran/{id}', LamaranController::class, 'lamaranPage', ['jobseeker']);
        $this->router->get('/riwayat', JobSeekerController::class, 'riwayatPage', ['jobseeker']);
        
        $this->router->post('/lamaran/{id}', LamaranController::class, 'submit', ['jobseeker']);

        //debugging 
        $this->router->get('/debug', UserController::class, 'debug');
        $this->router->post('/debugShow', UserController::class, 'showDebug');
        $this->router->post('/delete-database', UserController::class, 'deleteDB');
        $this->router->post('/create-database', UserController::class, 'createDB');
        $this->router->post('/seeding', UserController::class, 'seeding');

        $this->router->post('/debugShowLowongan', LowonganController::class, 'showDebug');
        $this->router->post('/debugShowLamaran', LamaranController::class, 'showDebug');
        $this->router->post('/debugShowCompanyDetail', CompanyController::class, 'showDebug');
        $this->router->post('/debugShowAttachment', AttachmentController::class, 'showDebug');
    }
}