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
        $jobs = $this->modelLowongan->getAllLowongan();

        // Get unique statuses and locations for filters
        $statuses = array_unique(array_column($jobs, 'is_open'));
        $locations = array_unique(array_column($jobs, 'jenis_lokasi'));

        // Sorting
        $sort = $_GET['sort'] ?? 'lowongan_id';
        usort($jobs, function($a, $b) use ($sort) {
            return $a[$sort] <=> $b[$sort];
        });

        // Filtering
        $statusFilter = $_GET['status'] ?? '';
        $locationFilter = $_GET['location'] ?? '';
        $searchTerm = $_GET['search'] ?? '';

        if (!empty($statusFilter) || !empty($locationFilter) || !empty($searchTerm)) {
            $jobs = array_filter($jobs, function($job) use ($statusFilter, $locationFilter, $searchTerm) {
                $matchesStatus = empty($statusFilter) || $job['is_open'] == $statusFilter;
                $matchesLocation = empty($locationFilter) || $job['jenis_lokasi'] == $locationFilter;
                $matchesSearch = empty($searchTerm) || stripos($job['posisi'], $searchTerm) !== false || stripos($job['deskripsi'], $searchTerm) !== false;
                return $matchesStatus && $matchesLocation && $matchesSearch;
            });
        }

        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 5;
        $totalJobs = count($jobs);
        $totalPages = ceil($totalJobs / $perPage);
        $jobs = array_slice($jobs, ($page - 1) * $perPage, $perPage);

        $this->view('Company', 'HomeCompany', [
            'jobs' => $jobs,
            'statuses' => $statuses,
            'locations' => $locations,
            'sort' => $sort,
            'statusFilter' => $statusFilter,
            'locationFilter' => $locationFilter,
            'searchTerm' => $searchTerm,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }

}
