<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
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
        $sort = $_GET['sort'] ?? 'posisi'; // Default sort by 'posisi'

        $currentPage = (int)($_GET['page'] ?? 1);
        
        if (!empty($search) || !empty($locationFilter) || !empty($statusFilter) || !empty($sort)) {
            $lowonganList = $this->modelLowongan->getSearchQuery($search, $locationFilter, $statusFilter, $sort);
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
        
        // Render the view with the filtered, sorted, and paginated data
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            // AJAX request
            $this->view('JobSeeker', 'HomeJobSeeker', [
                'lowonganList' => $currentItems,
                'statuses' => $statuses,
                'locations' => $locations,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'locationFilter' => $locationFilter,
                'statusFilter' => $statusFilter,
                'searchTerm' => $search,
                'sort' => $sort
            ]);
        } else {
            // Regular request
            $this->view('JobSeeker', 'HomeJobSeeker', [
                'lowonganList' => $currentItems,
                'statuses' => $statuses,
                'locations' => $locations,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'locationFilter' => $locationFilter,
                'statusFilter' => $statusFilter,
                'searchTerm' => $search,
                'sort' => $sort
            ]);
        }
    }
    
    

    public function companyHome()
    {
        $company_id = $_SESSION['id'];
        $companyData = $this->modelUsers->getUserById($company_id);


        //initialize the filters and sort 
        $search = $_GET['search'] ?? '';
        $locationFilter = $_GET['locations'] ?? '';
        $statusFilter = $_GET['statuses'] ?? '';
        $sort = $_GET['sort'] ?? 'posisi'; // Default sort by 'posisi'

        $currentPage = (int)($_GET['page'] ?? 1);

        if(!empty($search) || !empty($locationFilter) || !empty($statusFilter) || !empty($sort)) {
            // var_dump($search);
            // var_dump($locationFilter);
            // var_dump($statusFilter);
            // var_dump($sort);
            // var_dump("masuk sini");
            $jobList = $this->modelLowongan->getSearchQueryCompany($company_id, $search, $locationFilter, $statusFilter, $sort);
        } else {
            $jobList = $this->modelLowongan->getAllLowonganByCompanyID($company_id);
        }
        if ($jobList === false) {
            $jobList = [];
        }


        // foreach($jobList as &$job){
        //     $job['nama'] = $this->modelUsers->getUserById(($job['company_id']))['nama'];
        //     $job['lokasi'] = $this->modelUsers->getUserById(($job['company_id']))['lokasi'];
        //     $job['about'] = $this->modelUsers->getUserById(($job['company_id']))['about'];
        // }

        $statuses = array_unique(array_column($jobList, 'is_open'));
        $statuses = array_map(function($status) {
            return $status == 1 ? 'Open' : 'Closed';
        }, $statuses);
        $locations = array_unique(array_column($jobList, 'jenis_lokasi'));

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

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            // AJAX request
            $this->view('Company', 'HomeCompany', [
                'jobs' => $currentItems,
                'statuses' => $statuses,
                'locations' => $locations,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'locationFilter' => $locationFilter,
                'statusFilter' => $statusFilter,
                'searchTerm' => $search,
                'sort' => $sort, 
                'companyData' => $companyData
            ]);
        } else {
            // Regular request
            $this->view('Company', 'HomeCompany', [
                'jobs' => $currentItems,
                'statuses' => $statuses,
                'locations' => $locations,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'locationFilter' => $locationFilter,
                'statusFilter' => $statusFilter,
                'searchTerm' => $search,
                'sort' => $sort,
                'companyData' => $companyData
            ]);
        }
    }

}
