<?php

namespace App\Models;

class LowonganModel extends Model
{

    public function getAllLowongan(): array|false
    {
        $sql = "SELECT * FROM lowongan";
        $result = $this->db->fetchAll($sql);
        // var_dump($result);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getAllLowonganByCompanyID($id){
        $sql = "SELECT * FROM lowongan WHERE company_id = :company_id";
        $params = [':company_id' => $id];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function addLowongan($company_id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $is_open, $created_at, $updated_at)
    {
        $sql = "INSERT INTO lowongan (company_id, posisi, deskripsi, jenis_pekerjaan, jenis_lokasi, is_open, created_at, updated_at) VALUES (
            :company_id, 
            :posisi, 
            :deskripsi, 
            :jenis_pekerjaan, 
            :jenis_lokasi, 
            :is_open, 
            :created_at, 
            :updated_at
        )";
        $params = [
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

    public function deleteLowonganByID($id)
    {
        $sql = "DELETE FROM lowongan WHERE lowongan_id = :id";
        $params = [':id' => $id];
        return (bool) $this->db->execute($sql, $params);

    }

    public function toogleIsOpen($id)
    {
        $sql = "UPDATE lowongan SET is_open = NOT is_open
                WHERE lowongan_id = :id ";
        $params = [':id' => $id];
        return (bool) $this->db->execute($sql, $params);
    }

    //update lowongan data by id and choose the field
    public function updateLowonganField($id, $field, $value)
    {
        $allowedFields = ['lowongan_id', 'company_id', 'posisi', 'deskripsi', 'jenis_pekerjaan', 'jenis_lokasi', 'is_open', 'created_at', 'updated_at'];
        if (!in_array($field, $allowedFields)) {
            throw new \InvalidArgumentException("Invalid field name");
        }
        $sql = "UPDATE lowongan SET $field = :value WHERE id = :id";
        $params = [':value' => $value, ':id' => $id];
        return (bool) $this->db->execute($sql, $params);
    }

    public function updateLowongan($id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $is_open)
    {
        $sql = "UPDATE lowongan 
            SET posisi = :posisi, 
                deskripsi = :deskripsi, 
                jenis_pekerjaan = :jenis_pekerjaan, 
                jenis_lokasi = :jenis_lokasi, 
                is_open = :is_open 
            WHERE lowongan_id = :id";

        $params = [
            ':posisi' => $posisi,
            ':deskripsi' => $deskripsi,
            ':jenis_pekerjaan' => $jenis_pekerjaan,
            ':jenis_lokasi' => $jenis_lokasi,
            ':is_open' => $is_open,
            ':id' => $id
        ];

        return (bool) $this->db->execute($sql, $params);
    }


    public function getLowonganByID($id)
    {
        $sql = "SELECT * FROM lowongan WHERE lowongan_id = :lowongan_id";
        $params = [':lowongan_id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLowonganByCompanyId($company_id)
    {
        $sql = "SELECT * FROM lowongan WHERE company_id = :company_id";
        $params = [':company_id' => $company_id];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLowonganByPosisi($posisi)
    {
        $sql = "SELECT * FROM lowongan WHERE posisi = :posisi";
        $params = [':posisi' => $posisi];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }
    public function getLowonganByJenisPekerjaan($jenis_pekerjaan)
    {
        $sql = "SELECT * FROM lowongan WHERE jenis_pekerjaan = :jenis_pekerjaan";
        $params = [':jenis_pekerjaan' => $jenis_pekerjaan];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }
    public function getLowonganByJenisLokasi($jenis_lokasi)
    {
        $sql = "SELECT * FROM lowongan WHERE jenis_lokasi = :jenis_lokasi";
        $params = [':jenis_lokasi' => $jenis_lokasi];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLowonganByIsOpen($is_open)
    {
        $sql = "SELECT * FROM lowongan WHERE is_open = :is_open";
        $params = [':is_open' => $is_open];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLastLowonganID(): int|false
    {
        $sql = "SELECT MAX(lowongan_id) as last_id FROM lowongan";
        $result = $this->db->fetch($sql);
        if ($result && isset($result['last_id'])) {
            return (int) $result['last_id'];
        }
        return false;
    }

    public function getDetailLowonganByIDWithoutLamaran($id)
    {
        $sql =
            "SELECT * 
        FROM lowongan 
        JOIN company_detail 
            ON lowongan.company_id = company_detail.company_id
        WHERE 
            lowongan.lowongan_id = :lowongan_id";
        $params = [
            ':lowongan_id' => $id,
        ];
        $result = $this->db->fetch($sql, $params);
        // var_dump($result);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLamaranDateUserInLowongan($id, $user_id)
    {
        $sql =
        "SELECT lamaran.created_at
        FROM lamaran
        JOIN users 
            ON lamaran.user_id = users.user_id
        JOIN lowongan 
            ON lamaran.lowongan_id = lowongan.lowongan_id
        WHERE 
            lamaran.lowongan_id = :lowongan_id
            AND 
            users.user_id = :user_id";
        $params = [
            ':lowongan_id' => $id,
            ':user_id' => $user_id
        ];
        $result = $this->db->fetch($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getDetailLowonganByID($id, $user_id)
    {
        $sql =
            "SELECT * 
        FROM lowongan 
        JOIN company_detail 
            ON lowongan.company_id = company_detail.company_id
        JOIN lamaran
            ON lowongan.lowongan_id = lamaran.lowongan_id
        WHERE 
            lowongan.lowongan_id = :lowongan_id
            AND 
            lamaran.user_id = :user_id";

        $params = [
            ':lowongan_id' => $id,
            ':user_id' => $user_id
        ];
        $result = $this->db->fetch($sql, $params);
        // var_dump($result);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getSearchQuery($query, $locations = [], $statuses = [], $sort = 'posisi')
    {
        // Base SQL query 
        $sql = "SELECT * FROM lowongan WHERE (posisi LIKE :query OR deskripsi LIKE :query)";

        // Prepare parameters for query searching 
        $params = [':query' => "%$query%"];
        // Apply location filter if provided
        //the $sql will append with locations, statuses, and sort if those aren't empty
        if(!empty($locations)){
            // Create named placeholders for locations
            $locationPlaceholders = [];
            foreach ($locations as $index => $location) {
                $locationPlaceholders[] = ":location_$index"; // Named placeholder
                $params[":location_$index"] = $location; // Set value in params
            }
            //append the sql with locations
            $sql .= " AND jenis_lokasi IN (" . implode(',', $locationPlaceholders) . ")";
        }
        
        // Apply status filter if provided (0 or 1 for is_open)
        if(!empty($statuses)){
            // Create named placeholders for statuses
            $statusPlaceholders = [];
            foreach ($statuses as $index => $status) {
                $statusPlaceholders[] = ":status_$index"; // Named placeholder
                $params[":status_$index"] = $status; // Set value in params
            }
            //append the sql with statuses
            $sql .= " AND is_open IN (" . implode(',', $statusPlaceholders) . ")";
        }

        // Sort by the specified field
        $allowedSortFields = ['posisi', 'created_at', 'company_id'];
        if(in_array($sort, $allowedSortFields)){
            $sql .= " ORDER BY $sort";  
        }else{
            $sql .= " ORDER BY posisi"; //default
        }
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }

    public function getSearchQueryCompany($company_id, $query, $locations = [], $statuses = [], $sort = 'posisi'){
        $sql = "SELECT * FROM lowongan WHERE company_id = :company_id AND (posisi LIKE :query OR deskripsi LIKE :query)";

        $params = [':company_id' => $company_id, ':query' => "%$query%"];
        // Apply location filter if provided
        if(!empty($locations)){
            // Create named placeholders for locations
            $locationPlaceholders = [];
            foreach ($locations as $index => $location) {
                $locationPlaceholders[] = ":location_$index"; // Named placeholder
                $params[":location_$index"] = $location; // Set value in params
            }
            $sql .= " AND jenis_lokasi IN (" . implode(',', $locationPlaceholders) . ")";
        }

        // Apply status filter if provided (0 or 1 for is_open)

        if(!empty($statuses)){
            // Create named placeholders for statuses
            $statusPlaceholders = [];
            foreach ($statuses as $index => $status) {
                $statusPlaceholders[] = ":status_$index"; // Named placeholder
                $params[":status_$index"] = $status; // Set value in params
            }
            $sql .= " AND is_open IN (" . implode(',', $statusPlaceholders) . ")";
        }

        // Sort by the specified field
        $allowedSortFields = ['posisi', 'created_at', 'company_id'];
        if(in_array($sort, $allowedSortFields)){
            $sql .= " ORDER BY $sort";
        }else{
            $sql .= " ORDER BY posisi"; //default
        }
        $result = $this->db->fetchAll($sql, $params);
        if($result) return $result;
        else return false;
    }
}