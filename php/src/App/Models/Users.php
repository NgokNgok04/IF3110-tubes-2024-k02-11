<?php

namespace App\Models;
use App\Utils\Database;
use Exception;

class Users extends Model {
    public function getAllUsers(): array|false{
        try {
            $query = "SELECT * FROM users";
            $result = $this->db->fetchAll($query);
            print_r($result);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}