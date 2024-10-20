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
        $lowonganList = $this->modelLowongan->getAllLowongan();
        
        $statuses = array_unique(array_column($lowonganList, 'is_open'));
        $locations = array_unique(array_column($lowonganList, 'jenis_lokasi'));

        // Filters
        $locationFilter = $_GET['location'] ?? '';
        $statusFilter = $_GET['status'] ?? '';
        $searchTerm = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'posisi'; // Default sort by 'posisi'
    
        // echo $locationFilter;
        // Apply Filtering
        if (!empty($locationFilter) || !empty($searchTerm) || !empty($statusFilter)) {
            $lowonganList = array_filter($lowonganList, function ($lowongan) use ($locationFilter, $statusFilter, $searchTerm) {
                $matchesLocation = empty($locationFilter) || $lowongan['jenis_lokasi'] === $locationFilter;
                $matchesStatus = empty($statusFilter) || (string)$lowongan['is_open'] == (string)$statusFilter;
                $matchesSearch = empty($searchTerm) || 
                    stripos($lowongan['posisi'], $searchTerm) !== false || 
                    stripos($lowongan['deskripsi'], $searchTerm) !== false;
                return $matchesLocation && $matchesSearch && $matchesStatus;
            });
        }
    
        // Apply Sorting
        usort($lowonganList, function ($a, $b) use ($sort) {
            return $a[$sort] <=> $b[$sort];
        });
    
        $company = [];
        foreach($lowonganList as $lowongan){
            $company[] = $this->modelUsers->getUserById($lowongan['company_id']);
        }
        // Pagination
        $itemsPerPage = 12;
        $totalItems = count($lowonganList);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
    
        $offset = ($currentPage - 1) * $itemsPerPage;
        $currentItems = array_slice($lowonganList, $offset, $itemsPerPage);
    
        // Render the view with the filtered, sorted, and paginated data
        $this->view('JobSeeker', 'HomeJobSeeker', [
            'companyData' => $company,
            'lowonganList' => $currentItems,
            'statuses' => $statuses,
            'locations' => $locations,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'locationFilter' => $locationFilter,
            'statusFilter' => $statusFilter,
            'searchTerm' => $searchTerm,
            'sort' => $sort
        ]);
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
