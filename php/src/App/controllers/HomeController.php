<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Interfaces\ControllerInterface;
use App\Core\Database;
use App\Models\LowonganModel;

class HomeController extends Controller implements ControllerInterface
{
    private LowonganModel $modelLowongan;
    public function __construct()
    {
        $this->modelLowongan = $this->model('LowonganModel');
    }
    public function index()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            $this->companyHome();

        } else {
            $this->jobSeekerHome();
        }
    }

    // private function jobSeekerHome()
    // {
    //     $lowonganList = $this->modelLowongan->getAllLowongan(); 
    //     $this->view('JobSeeker', 'HomeJobSeeker', ['lowonganList' => $lowonganList]);
    // }

    private function jobSeekerHome()
    {
        $lowonganList = $this->modelLowongan->getAllLowongan();

        // Pagination
        $itemsPerPage = 10;
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

        $this->view('JobSeeker', 'HomeJobSeeker', [
            'lowonganList' => $currentItems,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
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
