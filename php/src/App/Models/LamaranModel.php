<?php

namespace App\Models;

use App\Models\Model;
use Exception;

class LamaranModel extends Model
{
    public function getAllLamaran()
    {
        $sql = "SELECT * FROM lamaran";
        // var_dump($this->db->fetchAll($sql));
        return $this->db->fetchAll($sql);
    }

    public function getLamaranById($id)
    {
        $sql = "SELECT * FROM lamaran  WHERE lamaran_id = :lamaran_id";
        $params = [':lamaran_id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result) {
            return $result;
        }
        return false;
    }

    public function getLamaranByUserID($id)
    {
        $sql = "SELECT * FROM lamaran WHERE user_id = :user_id";
        $params = [':user_id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function addLamaran($lamaran_id, $user_id, $lowongan_id, $cv_path, $video_path, $status, $status_reason, $created_at)
    {
        $sql = "INSERT INTO lamaran (lamaran_id, user_id, lowongan_id, cv_path, video_path, status, status_reason, created_at) VALUES (
            :lamaran_id, :user_id, :lowongan_id, :cv_path, :video_path, :status, :status_reason, :created_at)
        ";
        $params = [
            ':user_id' => $user_id,
            ':lowongan_id' => $lowongan_id,
            ':cv_path' => $cv_path,
            ':video_path' => $video_path,
            ':status' => $status,
            ':status_reason' => $status_reason,
            ':created_at' => $created_at
        ];
        $result = $this->db->execute($sql, $params);
        if ($result)
            return true;
        return false;
    }

    public function deleteLamaranByID($id)
    {
        $sql = "DELETE FROM lamaran WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        if ($result)
            return true;
        return false;
    }

    public function updateLamaran($lamaran_id, $user_id, $lowongan_id, $cv_path, $video_path, $status, $status_reason, $created_at)
    {
        $sql = "UPDATE lamaran SET user_id = :user_id, lowongan_id = :lowongan_id, cv_path = :cv_path, video_path = :video_path, status = :status, status_reason = :status_reason, created_at = :created_at WHERE lamaran_id = :lamaran_id";
        $params = [
            ':user_id' => $user_id,
            ':lowongan_id' => $lowongan_id,
            ':cv_path' => $cv_path,
            ':video_path' => $video_path,
            ':status' => $status,
            ':status_reason' => $status_reason,
            ':created_at' => $created_at,
            ':lamaran_id' => $lamaran_id
        ];
        $result = $this->db->execute($sql, $params);
        if ($result)
            return true;
        return false;
    }

    public function updateLamaranField($lamaran_id, $field, $value)
    {
        $allowedFields = ['user_id', 'lowongan_id', 'cv_path', 'video_path', 'status', 'status_reason', 'created_at'];
        if (!in_array($field, $allowedFields)) {
            throw new Exception("Allowed fields are: 'user_id', 'lowongan_id', 'cv_path', 'video_path', 'status', 'status_reason', 'created_at'");
        }
        $sql = "UPDATE lamaran SET $field = :value WHERE lamaran_id = :lamaran_id";
        $params = [
            ':value' => $value,
            ':lamaran_id' => $lamaran_id
        ];
        $result = $this->db->execute($sql, $params);
        if ($result)
            return true;
        return false;
    }

    public function updateStatus($id, $status, $reason)
    {
        $sql = "UPDATE lamaran SET status = :status, status_reason = :reason WHERE lamaran_id = :id";
        $params = [
            ':status' => $status,
            ':reason' => $reason,
            ':id' => $id
        ];
        $result = $this->db->execute($sql, $params);
        if ($result)
            return true;
        return false;
    }


    //might need to change 
    public function getLamaranByLowonganID($id)
    {
        $sql = "SELECT * FROM lamaran WHERE lowongan_id = :lowongan_id";
        $params = [':lowongan_id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLamaranStatusAndNamaBYLowonganID($id)
    {
        $sql = "SELECT lamaran.lamaran_id, lamaran.status, users.nama 
                FROM lamaran 
                JOIN users ON lamaran.user_id = users.user_id 
                WHERE lamaran.lowongan_id = :id";
        $params = [':id' => $id];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getLamaranPage($id)
    {
        $sql =
            "SELECT * 
        FROM lowongan AS lo 
        JOIN company_detail AS cd 
            ON cd.company_id = lo.company_id
        WHERE lo.lowongan_id = :lowongan_id
        ";

        $params = [':lowongan_id' => $id];
        $result = $this->db->fetch($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

    public function getRiwayatPage($id)
    {
        $sql =
            "SELECT * 
        FROM lamaran AS l 
        JOIN lowongan AS lo 
            ON l.lowongan_id = lo.lowongan_id 
        JOIN company_detail AS cd
            ON lo.company_id = cd.company_id
        JOIN users AS u
            ON l.user_id = u.user_id
        WHERE l.user_id = :user_id
        ";
        $params = [':user_id' => $id];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

}