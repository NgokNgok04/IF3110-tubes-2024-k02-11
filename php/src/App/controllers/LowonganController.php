<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\CompanyDetailModel;
use App\Models\LowonganModel;
use App\Models\AttachmentModel;
use App\Models\LamaranModel;
use Exception;
class LowonganController extends Controller
{
    private LowonganModel $model;
    private CompanyDetailModel $companyModel;
    private AttachmentModel $attachmentModel;
    private LamaranModel $lamaranModel;

    public function __construct()
    {
        $this->model = $this->model('LowonganModel');
        $this->companyModel = $this->model('CompanyDetailModel');
        $this->attachmentModel = $this->model('AttachmentModel');
        $this->lamaranModel = $this->model('LamaranModel');
    }

    public function tambahLowonganPage()
    {
        $this->view('Company', 'TambahLowongan');
    }

    public function editLowonganPage($id)
    {
        $lowongan = $this->model->getLowonganByID(($id));
        $this->view('Company', 'EditLowongan', [
            'lowongan' => $lowongan,
        ]);

    }


    //detail lowongan Page
    public function detailLowonganPage($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            $lowongan = $this->model->getLowonganByID(($id));
            $listLamaran = $this->lamaranModel->getLamaranStatusAndNamaBYLowonganID($id);
            $this->view('Company', 'DetailLowongan', [
                'lowongan' => $lowongan,
                'listLamaran' => $listLamaran
            ]);
        } else {
            $detailLowongan = $this->model->getDetailLowonganByID($id, $_SESSION['id']);
            $date = $this->model->getLamaranDateUserInLowongan($id, $_SESSION['id']);
            if(!$detailLowongan){
                $detailLowongan = $this->model->getDetailLowonganByIDWithoutLamaran($id);
            }
            $this->view('JobSeeker', 'DetailLowongan', ['lowongan' => $detailLowongan, 'date' => $date]);
        }
    }

    public function deleteLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $isDeleted = $this->model->deleteLowonganByID($id);

            if ($isDeleted) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Lowongan berhasil dihapus']);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus lowongan']);
            }
        } else {
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['status' => 'error', 'message' => 'Method tidak diizinkan']);
        }
    }


    public function deleteAttachment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['file_path'])) {
                $originalPath = $data['file_path'];
                $decodedFilePath = urldecode($originalPath);
                $file_path = WORK_DIR . $decodedFilePath;

                // if ($file_path && file_exists($file_path)) {
                if ($file_path && file_exists($file_path)) {
                    try {
                        if (!unlink($file_path)) {
                            throw new Exception('Failed to delete the image.');
                        }

                        $this->attachmentModel->deleteAttachmentById($data['attachment_id']);

                        http_response_code(200);
                        echo json_encode(['status' => 'success', 'message' => 'Image and attachment deleted successfully.']);
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
                    }
                } else {
                    http_response_code(404);
                    echo json_encode(['status' => 'error', 'message' => 'Image not found.' . $file_path]);
                }
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'No image path provided.']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
        }
    }





    public function toogleLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $isToogled = $this->model->toogleIsOpen($id);

            if ($isToogled) {
                header('Content-Type: application/json');
                echo json_encode(['status' => 'success', 'message' => 'Lowongan berhasil ditutup']);
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['status' => 'error', 'message' => 'Gagal menutup lowongan']);
            }
        } else {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['message' => 'Metode tidak diizinkan.']);
        }
    }


    public function updateLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $posisi = $_POST['posisi'] ?? null;
            $deskripsi = $_POST['deskripsi'] ?? null;
            $jenis_pekerjaan = $_POST['jenis_pekerjaan'] ?? null;
            $jenis_lokasi = $_POST['jenis_lokasi'] ?? null;
            $is_open = $_POST['is_open'];
            $is_open === 'true' ? true : false;

            $attachments = $_FILES['attachments'];
            $uploadedFilePaths = [];
            $attachmentIds = [];

            $allowedTypes = ['image/jpeg', 'image/png'];

            try {
                if (isset($attachments['tmp_name']) && is_array($attachments['tmp_name'])) {
                    foreach ($attachments['tmp_name'] as $key => $tempPath) {
                        if ($attachments['error'][$key] === UPLOAD_ERR_NO_FILE) {
                            continue;
                        }


                        if ($attachments['error'][$key] === UPLOAD_ERR_OK) {
                            $originalName = $attachments['name'][$key];
                            $fileType = mime_content_type($tempPath);

                            if (!in_array($fileType, $allowedTypes)) {
                                throw new Exception("Invalid file type: " . $originalName . ". Only JPEG and PNG files are allowed.");
                            }


                            $newFileName = uniqid() . '_' . basename($originalName);
                            $relativePath = RELATIVE_FILE_DIR . $newFileName;
                            $newFilePath = WORK_DIR . $relativePath;

                            if (move_uploaded_file($tempPath, $newFilePath)) {
                                $attachmentId = $this->attachmentModel->addAttachment($id, $relativePath);
                                if ($attachmentId !== false) {
                                    $uploadedFilePaths[] = $newFilePath;
                                    $attachmentIds[] = $attachmentId;
                                } else {
                                    throw new Exception("Failed to insert attachment into the database.");
                                }
                            } else {
                                throw new Exception("Failed to move uploaded file.");
                            }
                        } else {
                            http_response_code(500);
                            throw new Exception("Error uploading file: " . $attachments['error'][$key]);
                        }
                    }
                }

                $this->model->updateLowongan($id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi, $is_open);
                http_response_code(200);
                echo json_encode(['message' => 'Lowongan berhasil diperbarui']);
            } catch (Exception $e) {
                // undo
                foreach ($uploadedFilePaths as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                foreach ($attachmentIds as $attachmentId) {
                    $this->attachmentModel->deleteAttachmentByID($attachmentId);
                }

                http_response_code(500);
                echo json_encode(['message' => 'Failed to update lowongan: ' . $e->getMessage()]);
                return;
            }
        } else {
            http_response_code(405); 
            echo json_encode(['message' => 'Metode tidak diizinkan.']);
        }
    }


    public function showDebug()
    {
        $lowongans = $this->model->getAllLowongan();
        $this->view('User', 'DebugPage', ['lowongans' => $lowongans]);
        //TODO
    }


    public function storeLowongan()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $company_id = $_SESSION['id'];
            $posisi = $_POST['posisi'];
            $deskripsi = $_POST['deskripsi'];
            $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
            $jenis_lokasi = $_POST['jenis_lokasi'];

            $attachments = $_FILES['attachments'];

            $uploadedFilePaths = [];
            $attachmentIds = [];
            $lowongan_id = '';
            $allowedTypes = ['image/jpeg', 'image/png'];
            try {
                if ($attachments && isset($attachments['tmp_name']) && is_array($attachments['tmp_name'])) {
                    $lowongan_id = $this->model->addLowongan($company_id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi);
                    foreach ($attachments['tmp_name'] as $key => $tempPath) {
                        if ($attachments['error'][$key] === UPLOAD_ERR_NO_FILE) {
                            continue;
                        }

                        if ($attachments['error'][$key] === UPLOAD_ERR_OK) {
                            $originalName = $attachments['name'][$key];
                            $fileType = mime_content_type($tempPath);

                            if (!in_array($fileType, $allowedTypes)) {
                                throw new Exception("Invalid file type: " . $originalName . ". Only JPEG and PNG files are allowed.");
                            }

                            $newFileName = uniqid() . '_' . basename($originalName);
                            $relativePath = RELATIVE_FILE_DIR . $newFileName;
                            $newFilePath = WORK_DIR . $relativePath;

                            if (move_uploaded_file($tempPath, $newFilePath)) {
                                $attachmentId = $this->attachmentModel->addAttachment($lowongan_id, $relativePath);
                                if ($attachmentId !== false) {
                                    $uploadedFilePaths[] = $newFilePath;
                                    $attachmentIds[] = $attachmentId;
                                } else {
                                    throw new Exception("Failed to insert attachment into the database.");
                                }
                            } else {
                                throw new Exception("Failed to move uploaded file.");
                            }
                        } else {
                            http_response_code(500);
                            throw new Exception("Error uploading file: " . $attachments['error'][$key]);
                        }
                    }
                } else {
                    $lowongan_id = $this->model->addLowongan($company_id, $posisi, $deskripsi, $jenis_pekerjaan, $jenis_lokasi);
                }
                header('Location: /detail-lowongan/' . $lowongan_id);
            } catch (Exception $e) {
                // undo
                if ($lowongan_id)
                    $this->model->deleteLowonganByID($lowongan_id);

                foreach ($uploadedFilePaths as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                foreach ($attachmentIds as $attachmentId) {
                    $this->attachmentModel->deleteAttachmentByID($attachmentId);
                }


                if (!headers_sent()) {
                    http_response_code(500);
                }
                echo json_encode(['message' => 'Failed to add lowongan: ' . $e->getMessage()]);
                return;
            }
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Metode tidak diizinkan.']);
        }
    }
}