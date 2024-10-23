<?php

namespace App\Models;

use App\Models\Model;
use Exception;

class AttachmentModel extends Model
{
    public function getAllAttachment()
    {
        $sql = "SELECT * FROM attachment_lowongan";
        return $this->db->fetchAll($sql);
    }

    public function addAttachment($lowongan_id, $file_path)
    {
        $sql = "INSERT INTO attachment_lowongan (lowongan_id, file_path) VALUES (
            :lowongan_id, :file_path)
        ";
        $params = [
            ':lowongan_id' => $lowongan_id,
            ':file_path' => $file_path
        ];
        $result = $this->db->execute($sql, $params);
        if ($result) {
            $stmt = $this->db->prepare("SELECT LASTVAL()");
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        return false;
    }

    public function deleteAttachmentByID($id)
    {
        $sql = "DELETE FROM attachment_lowongan WHERE attachment_id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        if ($result)
            return true;
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
        if ($result)
            return true;
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
        if ($result)
            return true;
        return false;
    }

    //might need to change the query
    public function getAttachmentByLowonganID($id)
    {
        $sql = "SELECT * FROM attachment_lowongan WHERE lowongan_id = :lowongan_id";
        $params = [':lowongan_id' => $id];
        $result = $this->db->fetchAll($sql, $params);
        if ($result)
            return $result;
        else
            return false;
    }

}
