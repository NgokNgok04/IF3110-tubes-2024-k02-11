<?php

namespace App\Models;

use Exception;



//refactor: PDO stay safe. 
class UsersModel extends Model
{
    // Get all user data
    public function getAllUsers(): array|false
    {
        $sql = "SELECT * FROM users";
        $result = $this->db->fetchAll($sql);
        return $result ?: false;
    }

    // Check if user is valid
    public function isUserValid($email, $password): array|bool
    {
        $sql = "SELECT password FROM users WHERE email = :email AND password = :password";
        $params = [':email' => $email, ':password' => $password];
        $result = $this->db->fetch($sql, $params);
        return $result ?: false;
    }

    // Add new user data
    public function addUser($name, $email, $role, $password): bool
    {
        $sql = "INSERT INTO users (nama, email, role, password) VALUES (:name, :email, :role, :password)";
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':role' => $role,
            ':password' => $password
        ];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    // add new user company
    public function addCompanyUser($name, $email, $role, $password, $location, $about): bool
    {
        $this->addUser($name, $email, $role, $password);
        $sql_user_id = "SELECT user_id FROM users WHERE email = :email";
        $params_user_id = [
            ':email' => $email,
        ];
        $user_id = $this->db->fetch($sql_user_id, $params_user_id);
        $sql = "INSERT INTO company_detail (company_id, company_name, lokasi, about) VALUES (:company_id,:company_name,:lokasi, :about)";
        $params = [
            ':company_id' => $user_id['user_id'],
            ':company_name' => $name,
            ':lokasi' => $location,
            ':about' => $about,
        ];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    // Delete user data
    public function deleteUserByID($id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    // Update user data
    public function updateUser($id, $name, $email, $password): bool
    {
        $sql = "UPDATE users SET nama = :name, email = :email, password = :password WHERE id = :id";
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':password' => $password,
            ':id' => $id
        ];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    public function updateName($id, $nama)
    {
        $sql = "UPDATE users SET nama = :nama WHERE user_id = :id";
        $params = [
            ':nama' => $nama,
            ':id' => $id
        ];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    public function updateUserField($id, $field, $value): bool
    {
        $allowedFields = ['nama', 'email', 'password'];
        if (!in_array($field, $allowedFields)) {
            throw new Exception("Allowed fields are: 'nama', 'email', 'password'");
        }
        $sql = "UPDATE users SET $field = :value WHERE id = :id";
        $params = [':value' => $value, ':id' => $id];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    // Get user data by ID
    public function getUserById($id): array|false
    {
        $sql = "SELECT * FROM users WHERE user_id = :id";
        $params = [':id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result['role'] === 'company') {
            $company = $this->getCompanyLocAndDesc($result['user_id']);
            $result['lokasi'] = $company['lokasi'];
            $result['about'] = $company['about'];
        }
        return $result ?: false;
    }

    public function getCompanyLocAndDesc($id)
    {
        $sql = 'SELECT lokasi, about FROM company_detail WHERE company_id = :id';
        $params = [':id' => $id];
        $result = $this->db->fetch($sql, $params);
        return $result;
    }

    // Get user data by email
    public function getUserByEmail($email): array|false
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $params = [':email' => $email];
        $result = $this->db->fetch($sql, $params);
        return $result ?: false;
    }

}
