<?php

namespace App\Models;
use App\Utils\Database;

class Model {
    protected $db; 

    public function __construct() {
        $this->db = $db ?? new Database();
    }
}