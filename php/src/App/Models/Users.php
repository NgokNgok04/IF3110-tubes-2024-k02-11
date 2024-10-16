<?php

namespace App\Models;
use App\Core\Database;
use Exception;

class Users extends Model {

    public const Jobseeker = 'jobseeker';
    public const Company = 'company';
    
    //get all user data
    public function getAllUsers(): array|false{
        $sql = "SELECT * FROM users";
        $result = $this->db->fetchAll($sql);
        if($result) return $result;
        else return false;
    }

    //add new user data
    public function addUser($name, $email, $role, $password) {
        $sql = "INSERT INTO users (nama, email, role, password) VALUES (:name, :email, :role, :password)";
        
        $params = [
            ':name'     => $name,
            ':email'    => $email,
            ':role'     => $role,
            ':password' => $password,
        ];
    
        try {
            $result = $this->db->execute($sql, $params);
            return $result ? true : false;
        } catch (Exception $e) {
            // Log or display the error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    //delete user data
    public function deleteUser($id){
        $sql = "DELETE FROM users WHERE id = $1";
        $params = [$id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    //updating user data
    public function updateUser($id, $name, $email, $password){
        $sql = "UPDATE users SET nama = $1, email = $2, password = $3 WHERE id = $4";
        $params = [$name, $email, $password, $id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    //get user data by id
    public function getUserById($id){
        $sql = "SELECT * FROM users WHERE id = $1";
        $params = [$id];
        $result = $this->db->fetch($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getUserByUsername($username){
        $sql = "SELECT * FROM users WHERE nama = $1";
        $params = [$username];
        $result = $this->db->fetch($sql, $params);
        if($result) return $result;
        else return false;
    }
}