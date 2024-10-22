<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>

    <link rel="stylesheet" href="../../../public/styles/company/edit-lowongan.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card">
            <h3 class="title">Edit Job</h3>
            <form id="edit-lowongan-form">

                <div class="form-group">
                    <label>Current Attachments</label>
                    <div id="current-attachments">
                        <?php foreach ($attachment as $attach): ?>
                            <?php if (isset($attach['file_path'])): ?>
                                <div class="attachment-container">
                                    <img src="<?php echo htmlspecialchars($attach['file_path']); ?>" alt="Attachment"
                                        class="attachment-image">
                                    <button type="button" class="remove-attachment"
                                        data-id="<?php echo htmlspecialchars($attach['attachment_id']); ?>">Remove</button>

                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Job Title -->
                <div class="form-group">
                    <label for="position">Job Title</label>
                    <input type="text" class="form-control" id="position" name="posisi"
                        value="<?= $lowongan['posisi'] ?>" required>
                </div>

                <!-- Job Description -->
                <div class="form-group">
                    <label>Job Description</label>
                    <div id="description-container" class="editor"></div>
                    <input type="hidden" name="deskripsi" id="description"
                        value="<?= htmlspecialchars($lowongan['deskripsi']) ?>">
                </div>

                <!-- Job Type -->
                <div class="form-group">
                    <label for="jenis_pekerjaan">Job Type</label>
                    <select class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                        <option value="">Select Job Type</option>
                        <option value="Full-time" <?= $lowongan['jenis_pekerjaan'] == 'Full-time' ? 'selected' : '' ?>>
                            Full-time</option>
                        <option value="Part-time" <?= $lowongan['jenis_pekerjaan'] == 'Part-time' ? 'selected' : '' ?>>
                            Part-time</option>
                        <option value="Internship" <?= $lowongan['jenis_pekerjaan'] == 'Internship' ? 'selected' : '' ?>>
                            Internship</option>
                    </select>
                </div>

                <!-- Location Type -->
                <div class="form-group">
                    <label for="jenis_lokasi">Location Type</label>
                    <select class="form-control" id="jenis_lokasi" name="jenis_lokasi" required>
                        <option value="">Select Location</option>
                        <option value="on-site" <?= $lowongan['jenis_lokasi'] == 'on-site' ? 'selected' : '' ?>>On-site
                        </option>
                        <option value="hybrid" <?= $lowongan['jenis_lokasi'] == 'hybrid' ? 'selected' : '' ?>>Hybrid
                        </option>
                        <option value="remote" <?= $lowongan['jenis_lokasi'] == 'remote' ? 'selected' : '' ?>>Remote
                        </option>
                    </select>
                </div>

                <!-- is open -->
                <div class="form-group">
                    <label for="is_open">Is Open</label>
                    <select class="form-control" id="is_open" name="is_open" required>
                        <option value="">Select Status</option>
                        <option value="true" <?= $lowongan['is_open'] ? 'selected' : '' ?>>Open</option>
                        <option value="false" <?= !$lowongan['is_open'] ? 'selected' : '' ?>>Close</option>
                    </select>
                </div>


                <button type="submit" class="btn">Update Job</button>
            </form>
        </div>
    </div>

    <!-- Quill.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="../../../public/js/edit-lowongan.js"></script>
    <script src="../../../public/js/quill-setup.js"></script>
</body>

</html>