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
        $sql = "INSERT INTO lowongan (lowongan_id, company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open, created_at, updated_at) VALUES (
            :lowongan_id,
            :company_id, 
            :posisi, 
            :deskripsi, 
            :jenis_pekerjaan, 
            :jenis_lokasi, 
            :is_open, 
            :created_at, 
            :updated_at, 
        )";
        $params = [
            ':lowongan_id' => $lowongan_id, 
            ':company_id' => $company_id, 
            ':posisi' => $posisi, 
            ':deskripsi' => $deskripsi,
            ':jenis_pekerjaan' => $jenis_pekerjaan,
            ':jenis_lokasi' => $jenis_lokasi,
            ':is_open' => $is_open,
            ':created_at' => $created_at,
            ':updated_at' => $updated_at  
        ];
        return (bool) $this->db->execute($sql, $params);
    }

    public function deleteLowonganByID($id){
        $sql = "DELETE FROM lowongan WHERE id = :id";
        $params = [':id' => $id];
        return (bool) $this->db->execute($sql, $params);

    }

    //update lowongan data by id and choose the field
    public function updateLowonganField($id, $field, $value){
        $allowedFields = ['lowongan_id', 'company_id', 'posisi', 'deskripsi', 'jenis_pekerjaan', 'jenis_lokasi', 'is_open', 'created_at', 'updated_at'];
        if (!in_array($field, $allowedFields)) {
            throw new \InvalidArgumentException("Invalid field name");
        }
        $sql = "UPDATE lowongan SET $field = :value WHERE id = :id";
        $params = [':value' => $value, ':id' => $id];
        return (bool) $this->db->execute($sql, $params);
    }

    public function getLowonganByCompanyId($company_id){
        $sql = "SELECT * FROM lowongan WHERE company_id = :company_id";
        $params = [':company_id' => $company_id];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByPosisi($posisi){
        $sql = "SELECT * FROM lowongan WHERE posisi = :posisi";
        $params = [':posisi' => $posisi];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }
    public function getLowonganByJenisPekerjaan($jenis_pekerjaan){
        $sql = "SELECT * FROM lowongan WHERE jenis_pekerjaan = :jenis_pekerjaan";
        $params = [':jenis_pekerjaan' => $jenis_pekerjaan];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }
    public function getLowonganByJenisLokasi($jenis_lokasi){
        $sql = "SELECT * FROM lowongan WHERE jenis_lokasi = :jenis_lokasi";
        $params = [':jenis_lokasi' => $jenis_lokasi];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getLowonganByIsOpen($is_open){
        $sql = "SELECT * FROM lowongan WHERE is_open = :is_open";
        $params = [':is_open' => $is_open];
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

}