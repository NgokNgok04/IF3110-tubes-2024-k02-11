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

        $user_id = $_SESSION['user_id'];
        $data= $this->model->getRiwayatPage($user_id);
        $user_data = $this->userModel->getUserById($user_id);

        $statuses = ['rejected', 'accepted', 'waiting'];
        $locations = ['onsite', 'remote', 'hybrid'];
        // var_dump($data);

        //filters 
        $locationFilter = $_GET['location'] ?? '';
        $statusFilter = $_GET['status'] ?? '';
        $searchTerm = $_GET['search'] ?? '';

        //filter by choose status and location 
        if(!empty($locationFilter) || !empty($statusFilter) || !empty($searchTerm)){
            $data = array_filter($data, function($lamaran) use ($locationFilter, $statusFilter, $searchTerm){
                $matchesLocation = empty($locationFilter) || $lamaran['jenis_lokasi'] === $locationFilter;
                $matchesStatus = empty($statusFilter) || $lamaran['status'] === $statusFilter;
                $matchesSearch = empty($searchTerm) || 
                    stripos($lamaran['posisi'], $searchTerm) !== false || 
                    stripos($lamaran['company_name'], $searchTerm) !== false;
                return $matchesLocation && $matchesStatus && $matchesSearch;
            });
        }
        //sort by date 
        usort($data, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });


        $itemsPerPage = 12;
        $totalItems = count($data);
        $totalPages = ceil($totalItems / $itemsPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
    
        $offset = ($currentPage - 1) * $itemsPerPage;
        $currentItems = array_slice($data, $offset, $itemsPerPage);


        //send view
        $this->view('JobSeeker', 'Riwayat', [
            'data' => $data, 
            'locations' => $locations,
            'statuses' => $statuses,
            'locationFilter' => $locationFilter,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'statusFilter' => $statusFilter,
            'searchTerm' => $searchTerm, 
            'user_data' => $user_data
        ]);
    }


}