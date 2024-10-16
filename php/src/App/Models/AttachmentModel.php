<?php

namespace App\Models; 

use App\Models\Model;
use Exception;

class AttachmentModel extends Model{
    public function getAllAttachment()
    {
        $sql = "SELECT * FROM attachment_lowongan";
        return $this->db->fetchAll($sql);
    }

    public function addAttachment($company_id, $attachment_name, $file_path)
    {
        $sql = "INSERT INTO attachment_lowongan (company_id, attachment_name, attachment_path) VALUES (
            :company_id, :attachment_name, :file_path)
        ";
        $params = [
            ':company_id' => $company_id, 
            ':attachment_name' => $attachment_name, 
            ':file_path' => $file_path
        ];
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;
    }

    public function deleteAttachmentByID($id)
    {
        $sql = "DELETE FROM attachment_lowongan WHERE id = :id";
        $params = [':id' => $id]; 
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;
    }

    public function updateAttachment($attachment_id, $lowongan_id, $file_path)
    {
        $sql = "UPDATE attachment_lowongan SET lowongan_id = :lowongan_id, attachment_path = :file_path WHERE attachment_id = :attachment_id";
        $params = [
            ':lowongan_id' => $lowongan_id,
            ':file_path' => $file_path,
            ':attachment_id' => $attachment_id
        ];
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;     
    }
    public function updateAttachmentField($attachment_id, $field, $value)
    {
        $allowedFields = ['lowongan_id', 'attachment_path'];
        if (!in_array($field, $allowedFields)) {
            throw new Exception("Allowed Fields are: 'lowongan_id', 'attachment_path'");
        }
        $sql = "UPDATE attachment_lowongan SET $field = :value WHERE attachment_id = :attachment_id";
        $params = [':value' => $value, ':attachment_id' => $attachment_id];
        $result = $this->db->execute($sql, $params);
        if($result) return true; 
        return false;     
    }

}
