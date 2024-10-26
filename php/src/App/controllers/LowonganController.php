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
        if (!$lowongan || $lowongan['company_id'] != $_SESSION['id']) {
            $this->view('Error', 'NoAccess');
        } else {
            $attchments = $this->attachmentModel->getAttachmentByLowonganID($id);
            $this->view('Company', 'EditLowongan', [
                'lowongan' => $lowongan,
                'attachments' => $attchments
            ]);
        }
    }

    //detail lowongan Page
    public function detailLowonganPage($id)
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'company') {
            $lowongan = $this->model->getLowonganByID(($id));
            if (!$lowongan || $lowongan['company_id'] != $_SESSION['id']) {
                $this->view('Error', 'NoAccess');
            } else {
                $listLamaran = $this->lamaranModel->getLamaranStatusAndNamaBYLowonganID($id);
                $this->view('Company', 'DetailLowongan', [
                    'lowongan' => $lowongan,
                    'listLamaran' => $listLamaran
                ]);
            }

        } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'jobseeker') {
            $detailLowongan = $this->model->getDetailLowonganByID($id, $_SESSION['id']);
            $date = $this->model->getLamaranDateUserInLowongan($id, $_SESSION['id']);
            if (!$detailLowongan) {
                $detailLowongan = $this->model->getDetailLowonganByIDWithoutLamaran($id);
            }
            $attachmentLowongan = $this->attachmentModel->getAttachmentByLowonganID($id);
            $this->view('JobSeeker', 'DetailLowongan', [
                'lowongan' => $detailLowongan,
                'date' => $date,
                'attachmentLowongan' => $attachmentLowongan
            ]);
        }
    }

    public function deleteLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lowongan = $this->model->getLowonganByID($id);
            if (!$lowongan || $lowongan['company_id'] != $_SESSION['id']) {
                $_SESSION['error_message'] = 'THIS IS NOT YOUR JOB POST!!!';
                header('Location: /');
                exit;
            }

            $isDeleted = $this->model->deleteLowonganByID($id);

            if ($isDeleted) {
                $_SESSION['success_message'] = 'Job deleted successfully!';
                header('Location: /');
            } else {
                $_SESSION['error_message'] = 'Unable to delete job!';
                header('Location: /');
            }
        } else {
            $_SESSION['error_message'] = 'Metode Not Allowed.';
            header('Location: /');
        }
    }

    public function deleteAttachment($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $lowongan = $this->model->getLowonganByID($id);
            if (!$lowongan || $lowongan['company_id'] != $_SESSION['id']) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'No image path provided.']);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['file_path'])) {
                $originalPath = $data['file_path'];
                $decodedFilePath = urldecode($originalPath);
                $file_path = WORK_DIR . $decodedFilePath;

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
                http_response_code(403);
                echo json_encode(['status' => 'error', 'message' => 'THIS IS NOT YOUR JOB POSTING']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
        }
    }

    public function updateLowonganIsOpen($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lowongan = $this->model->getLowonganByID($id);
            if (!$lowongan || $lowongan['company_id'] != $_SESSION['id']) {
                header('Content-Type: application/json', true, 403);
                echo json_encode(['status' => 'error', 'message' => 'THIS IS NOT YOUR JOB POST!!!']);
                exit;
            }

            if ($_POST['is_open'] === 'Open') {
                $is_open = 1;
            } else if ($_POST['is_open'] === 'Closed') {
                $is_open = 0;
            }

            $isUpdated = $this->model->updateIsOpen($id, $is_open);
            if ($isUpdated) {
                header('Content-Type: application/json');
                if ($is_open === 1) {
                    echo json_encode(['status' => 'success', 'message' => 'Job Opened ']);
                } else {
                    echo json_encode(['status' => 'success', 'message' => 'Job Closed']);
                }
            } else {
                header('Content-Type: application/json', true, 500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to Update Job Status']);
            }


        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed']);
        }
    }

    public function updateLowongan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lowongan = $this->model->getLowonganByID($id);
            if (!$lowongan || $lowongan['company_id'] != $_SESSION['id']) {
                http_response_code(403);
                $_SESSION['error_message'] = 'THIS IS NOT YOUR JOB POST!!!';
                header('Location: /');
                exit;
            }

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
                $_SESSION['success_message'] = 'Job updated successfully!';
                header('Location: /edit-lowongan/' . $id);
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
                $_SESSION['error_message'] = 'Failed to update lowongan: ' . $e->getMessage();
                header('Location: /edit-lowongan/' . $id);
                return;
            }
        } else {
            http_response_code(405);
            $_SESSION(['error_message' => 'Metode Not Allowed.']);
            header('Location: /edit-lowongan/' . $id);
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
                $_SESSION['success_message'] = 'Job added successfully!';
                header('Location: /');
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
                $_SESSION['error_message'] = 'Failed to add job: ' . $e->getMessage();
                header('Location: /tambah-lowongan');
                return;
            }
        } else {
            http_response_code(405);
            $_SESSION['error_message'] = 'Metode not allowed.';
            header('Location: /tambah-lowongan');
        }
    }
}