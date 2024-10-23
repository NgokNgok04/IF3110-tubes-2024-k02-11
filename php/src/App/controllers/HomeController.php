<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;
use App\Models\LowonganModel;
use App\Models\UsersModel;

class HomeController extends Controller implements ControllerInterface
{
    private LowonganModel $modelLowongan;
    private UsersModel $modelUsers;
    public function __construct()
    {
        $this->modelLowongan = $this->model('LowonganModel');
        $this->modelUsers = $this->model('UsersModel');
    }
    public function index()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            $this->companyHome();

        } else {
            $this->jobSeekerHome();
        }
    }

    public function jobSeekerHome()
    {
        // Initialize variables
        $search = $_GET['search'] ?? '';
        $locationFilter = $_GET['locations'] ?? '';
        $statusFilter = $_GET['statuses'] ?? '';
        $jobtypeFilter = $_GET['jobtypes'] ?? '';
        $sort = $_GET['sort'] ?? 'posisi'; // Default sort by 'posisi'

        $currentPage = (int)($_GET['page'] ?? 1);
        
        if (!empty($search) || !empty($locationFilter) || !empty($statusFilter) || !empty($sort) || !empty($jobtypeFilter)) {
            $lowonganList = $this->modelLowongan->getSearchQuery($search, $locationFilter, $statusFilter, $jobtypeFilter, $sort);
        } else {
            $lowonganList = $this->modelLowongan->getAllLowongan();
        }
        if ($lowonganList === false) {
            $lowonganList = [];
        }
        
        foreach($lowonganList as &$lowongan){
            $lowongan['nama'] = $this->modelUsers->getUserById(($lowongan['company_id']))['nama'];
            $lowongan['lokasi'] = $this->modelUsers->getUserById(($lowongan['company_id']))['lokasi'];
            $lowongan['about'] = $this->modelUsers->getUserById(($lowongan['company_id']))['about'];
        }
        // Prepare unique statuses and locations
        $statuses = array_unique(array_column($lowonganList, 'is_open'));
        // Map the numeric statuses to descriptive strings
        $statuses = array_map(function($status) {
            return $status == 1 ? 'Open' : 'Closed';
        }, $statuses);
        // var_dump($statuses);
        $locations = array_unique(array_column($lowonganList, 'jenis_lokasi'));
        $jobtypes = array_unique(array_column($lowonganList, 'jenis_pekerjaan'));
    
        // Pagination setup
        $itemsPerPage = 12;
        $totalItems = count($lowonganList);
        $totalPages = ceil($totalItems / $itemsPerPage);
        
        // Validate and adjust current page
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
    
        $offset = ($currentPage - 1) * $itemsPerPage;
        $currentItems = array_slice($lowonganList, $offset, $itemsPerPage);
        $this->view('JobSeeker', 'HomeJobSeeker', [
            'lowonganList' => $currentItems,
            // 'statuses' => $statuses,
            // 'locations' => $locations,
            // 'jobtypes' => $jobtypes,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            // 'locationFilter' => $locationFilter,
            // 'statusFilter' => $statusFilter,
            // 'jobtypeFilter' => $jobtypeFilter,
            'searchTerm' => $search,
            'sort' => $sort
        ]);
    }
    
    public function companyHome()
    {
        $company_id = $_SESSION['id'];
        $companyData = $this->modelUsers->getUserById($company_id);


        //initialize the filters and sort 
        $search = $_GET['search'] ?? '';
        $locationFilter = $_GET['locations'] ?? '';
        $statusFilter = $_GET['statuses'] ?? '';
        $jobtypeFilter = $_GET['jobtypes'] ?? '';
        $sort = $_GET['sort'] ?? 'posisi'; // Default sort by 'posisi'

        $currentPage = (int)($_GET['page'] ?? 1);

        if(!empty($search) || !empty($locationFilter) || !empty($statusFilter) || !empty($jobtypeFilter) || !empty($sort)) {
            // var_dump("masuk sini");
            $jobList = $this->modelLowongan->getSearchQueryCompany($company_id, $search, $locationFilter, $statusFilter, $jobtypeFilter, $sort);
        } else {
            $jobList = $this->modelLowongan->getAllLowonganByCompanyID($company_id);
        }
        if ($jobList === false) {
            $jobList = [];
        }

        $statuses = array_unique(array_column($jobList, 'is_open'));
        $statuses = array_map(function($status) {
            return $status == 1 ? 'Open' : 'Closed';
        }, $statuses);

        $locations = array_unique(array_column($jobList, 'jenis_lokasi'));
        $jobtypes = array_unique(array_column($jobList, 'jenis_pekerjaan'));

        $itemsPerPage = 12;
        $totalItems = count($jobList);
        $totalPages = ceil($totalItems / $itemsPerPage);
        
        // Validate and adjust current page
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
    
        $offset = ($currentPage - 1) * $itemsPerPage;
        $currentItems = array_slice($jobList, $offset, $itemsPerPage);
        $this->view('Company', 'HomeCompany', [
            'jobs' => $currentItems,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'searchTerm' => $search,
            'sort' => $sort, 
            'companyData' => $companyData
            // 'statuses' => $statuses,
            // 'locations' => $locations,
            // 'jobtypes' => $jobtypes,
            // 'locationFilter' => $locationFilter,
            // 'statusFilter' => $statusFilter,
            // 'jobtypeFilter' => $jobtypeFilter,
        ]);
    }
}
