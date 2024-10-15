<?php

namespace App\Models;
use App\Core\Database;

class CompanyDetail extends Model {
    //get all company data 
    public function getAllCompany(): array|false{
        $sql = "SELECT * FROM companydetail";
        $result = $this->db->fetchAll($sql);
        if($result) return $result;
        else return false;
    }

    //add new company data
    public function addCompanyDetail($user_id, $company_id, $company_name, $lokasi, $about){
        $sql = "INSERT INTO companydetail (user_id, company_id, company_name, lokasi, about) VALUES ($1, $2, $3, $4, $5)";
        $params = [$user_id, $company_id, $company_name, $lokasi, $about];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    //delete company data
    public function deleteCompanyDetail($id){
        $sql = "DELETE FROM companydetail WHERE id = $1";
        $params = [$id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    //updating company data
    public function updateCompanyDetail($company_id, $user_id, $lokasi, $about){
        $sql = "UPDATE companydetail SET user_id = $1, lokasi = $2, about = $3 WHERE company_id = $4";
        $params = [$user_id, $lokasi, $about, $company_id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    //get company data by id
    public function getCompanyById($id){
        $sql = "SELECT * FROM companydetail WHERE company_id = $1";
        $params = [$id];
        $result = $this->db->fetch($sql, $params);
        if($result) return $result;
        else return false;
    }

    //get company data by user_id
    public function getCompanyByUserId($user_id){
        $sql = "SELECT * FROM companydetail WHERE user_id = $1";
        $params = [$user_id];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    //get company data by lokasi
    public function getCompanyByLokasi($lokasi){
        $sql = "SELECT * FROM companydetail WHERE lokasi = $1";
        $params = [$lokasi];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }
}