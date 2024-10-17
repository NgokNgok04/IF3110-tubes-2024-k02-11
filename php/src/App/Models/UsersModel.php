<?php

namespace App\Models;

use Exception;



//refactor: PDO stay safe. 
class UsersModel extends Model {
    // Get all user data
    public function getAllUsers(): array|false {
        $sql = "SELECT * FROM users";
        $result = $this->db->fetchAll($sql);
        return $result ?: false;
    }

    // Check if user is valid
    public function isUserValid($email, $password): array|bool {
        $sql = "SELECT password FROM users WHERE email = :email AND password = :password";
        $params = [':email' => $email, ':password' => $password];
        $result = $this->db->fetch($sql, $params);
        return $result ?: false;
    }

    // Add new user data
    public function addUser($name, $email, $role, $password): bool {
        $sql = "INSERT INTO users (nama, email, role, password) VALUES (:name, :email, :role, :password)";
        $params = [
            ':name'     => $name,
            ':email'    => $email,
            ':role'     => $role,
            ':password' => $password
        ];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    // Delete user data
    public function deleteUserByID($id): bool {
        $sql = "DELETE FROM users WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    // Update user data
    public function updateUser($id, $name, $email, $password): bool {
        $sql = "UPDATE users SET nama = :name, email = :email, password = :password WHERE id = :id";
        $params = [
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $password,
            ':id'       => $id
        ];
        $result = $this->db->execute($sql, $params);
        return (bool) $result;
    }

    public function updateUserField($id, $field, $value): bool {
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
    public function getUserById($id): array|false {
        $sql = "SELECT * FROM users WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->fetch($sql, $params);
        return $result ?: false;
    }

    // Get user data by email
    public function getUserByEmail($email): array|false {
        $sql = "SELECT * FROM users WHERE email = :email";
        $params = [':email' => $email];
        $result = $this->db->fetch($sql, $params);
        return $result ?: false;
    }

}
