<?php

namespace App\Models;
use Exception;

//refactor
class CompanyDetailModel extends Model
{
    //get all company data 
    public function getAllCompany(): array|false
    {
        $sql = "SELECT * FROM company_detail";
        return $this->db->fetchAll($sql);
    }

    //add new company data
    public function addCompanyDetail($user_id, $company_id, $company_name, $lokasi, $about)
    {
        $sql = "INSERT INTO company_detail (user_id, company_id, company_name, lokasi, about) VALUES (
            :user_id, :company_id, :company_name, :lokasi, :about)
        ";
        $params = [
            ':user_id' => $user_id, 
            ':company_id' => $company_id, 
            ':company_name' => $company_name, 
            ':lokasi' => $lokasi, 
            ':about' => $about
        ];
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;
    }

    //delete company data
    public function deleteCompanyDetailByID($id)
    {
        $sql = "DELETE FROM company_detail WHERE id = :id";
        $params = [':id' => $id]; 
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;
    }

    //updating company data
    public function updateCompanyDetail($company_id, $user_id, $lokasi, $about): bool
    {
        $sql = "UPDATE company_detail SET user_id = :user_id, lokasi = :lokasi, about = :about WHERE company_id = :company_id";
        $params = [
            ':user_id' => $user_id,
            ':lokasi' => $lokasi,
            ':about' => $about,
            ':company_id' => $company_id
        ];
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;
    }

    public function updateCompanyField($company_id, $field, $value){
        $allowedFields = ['user_id', 'lokasi', 'about'];
        if (!in_array($field, $allowedFields)) {
            throw new Exception("Allowed Fields are: 'user_id', 'lokasi', 'about'");
        }
        $sql = "UPDATE company_detail SET $field = :value WHERE company_id = :company_id";
        $params = [':value' => $value, ':company_id' => $company_id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        return false;
    }


    //get company data by id
    public function getCompanyById($id)
    {
        $sql = "SELECT * FROM company_detail WHERE company_id = :company_id";
        $params = [':company_id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result) return $result; 
        return false;
    }

    //get company data by user_id
    public function getCompanyByUserId($user_id): array|false
    {
        $sql = "SELECT * FROM company_detail WHERE user_id = :user_id";
        $params = [':user_id' => $user_id];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        return false;
    }

    //get company data by lokasi
    public function getCompanyByLokasi($lokasi): array|false
    {
        $sql = "SELECT * FROM company_detail WHERE lokasi = :lokasi";
        $params = [':lokasi' => $lokasi];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        return false;
    }
}