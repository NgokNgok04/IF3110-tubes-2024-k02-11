<?php

namespace App\Models;

class Lowongan extends Model{
    
    public function getAllLowongan(): array|false{
        $sql = "SELECT * FROM lowongan";
        $result = $this->db->fetchAll($sql);
        if($result) return $result;
        else return false;
    }

    public function addLowongan($lowongan_id, $company_id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $is_open, $created_at, $updated_at){
        $sql = "INSERT INTO lowongan (lowongan_id, company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open, created_at, updated_at) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
        $params = [$lowongan_id, $company_id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $is_open, $created_at, $updated_at];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    public function deleteLowongan($id){
        $sql = "DELETE FROM lowongan WHERE id = $1";
        $params = [$id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    //update lowongan data by id and choose the field
    public function updateLowonganField($id, $field, $value){
        $allowedFields = ['lowongan_id', 'company_id', 'posisi', 'deskripsi', 'jenis_pekerjaan', 'jenis_lokasi', 'is_open', 'created_at', 'updated_at'];
        if (!in_array($field, $allowedFields)) {
            throw new \InvalidArgumentException("Invalid field name");
        }
        $sql = "UPDATE lowongan SET $field = $1 WHERE id = $2";
        $params = [$value, $id];
        $result = $this->db->execute($sql, $params);
        if($result) return true;
        else return false;
    }

    public function getLowonganById($id){
        $sql = "SELECT * FROM lowongan WHERE id = $1";
        $params = [$id];
        $result = $this->db->fetch($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByCompanyId($company_id){
        $sql = "SELECT * FROM lowongan WHERE company_id = $1";
        $params = [$company_id];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByPosisi($posisi){
        $sql = "SELECT * FROM lowongan WHERE posisi = $1";
        $params = [$posisi];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByJenisPekerjaan($jenis_pekerjaan){
        $sql = "SELECT * FROM lowongan WHERE jenis_pekerjaan = $1";
        $params = [$jenis_pekerjaan];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByJenisLokasi($jenis_lokasi){
        $sql = "SELECT * FROM lowongan WHERE jenis_lokasi = $1";
        $params = [$jenis_lokasi];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByIsOpen($is_open){
        $sql = "SELECT * FROM lowongan WHERE is_open = $1";
        $params = [$is_open];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

}