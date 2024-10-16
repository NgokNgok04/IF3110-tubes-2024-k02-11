<?php

namespace App\Core;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\LowonganController;
use App\Controllers\LamaranController;
use App\Controllers\CompanyController;
use App\Controllers\JobSeekerController;

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
    }
}