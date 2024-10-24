<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\LamaranModel;
use App\Models\UsersModel;

class JobSeekerController extends Controller
{
    private LamaranModel $model;
    private UsersModel $userModel;

    public function __construct()
    {
        $this->model = $this->model('LamaranModel');
        $this->userModel = $this->model('UsersModel');
    }

    public function riwayatPage()
    {
    $user_id = $_SESSION['id'];
    $data = $this->model->getRiwayatPage($user_id);
    if (!$data) $data = []; // Validasi jika data kosong
    $user_data = $this->userModel->getUserById($user_id);

    $statuses = ['rejected', 'accepted', 'waiting'];
    $locations = ['onsite', 'remote', 'hybrid'];

    // Filters
    $locationFilter = $_GET['location'] ?? '';
    $statusFilter = $_GET['status'] ?? '';
    $searchTerm = $_GET['search'] ?? '';
    $sort = $_GET['sort'] ?? 'created_at'; // Default sort by 'created_at'

    // Apply filters: location, status, and search term
    if (!empty($locationFilter) || !empty($statusFilter) || !empty($searchTerm)) {
        $data = array_filter($data, function ($lamaran) use ($locationFilter, $statusFilter, $searchTerm) {
            $matchesLocation = empty($locationFilter) || $lamaran['jenis_lokasi'] === $locationFilter;
            $matchesStatus = empty($statusFilter) || $lamaran['status'] === $statusFilter;
            $matchesSearch = empty($searchTerm) || 
                stripos($lamaran['posisi'], $searchTerm) !== false || 
                stripos($lamaran['company_name'], $searchTerm) !== false;
            return $matchesLocation && $matchesStatus && $matchesSearch;
        });
    }

    // Sort by date (newest first)
    usort($data, function ($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });

    // Pagination setup
    $itemsPerPage = 12;
    $totalItems = count($data);
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    // Get the items for the current page
    $offset = ($currentPage - 1) * $itemsPerPage;
    $currentItems = array_slice($data, $offset, $itemsPerPage);

    // Send view
    $this->view('JobSeeker', 'Riwayat', [
        'riwayatList' => $currentItems, // Only the items for the current page
        'data' => $data, 
        'locations' => $locations,
        'statuses' => $statuses,
        'locationFilter' => $locationFilter,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'statusFilter' => $statusFilter,
        'searchTerm' => $searchTerm, 
        'user_data' => $user_data,
        'sort' => $sort
    ]);
    }



}