<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>

    <link rel="stylesheet" href="../../../public/styles/company/edit-lowongan.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card">
            <h3 class="title">Add Job</h3>

            <form id="lowongan-form" method="POST" enctype="multipart/form-data">
                <!-- Job Title -->
                <div class="form-group">
                    <label for="position">Job Title</label>
                    <input type="text" class="form-control" id="position" name="posisi" required>
                </div>

                <!-- Job Description -->
                <div class="form-group">
                    <label>Job Description</label>
                    <div id="description-container" class="editor"></div>
                    <input type="hidden" name="deskripsi" id="description">
                </div>

                <!-- Job Type -->
                <div class="form-group">
                    <label for="jenis_pekerjaan">Job Type</label>
                    <select class="form-control" id="jenis_pekerjaan" name="jenis_pekerjaan" required>
                        <option value="">Select Job Type</option>
                        <option value="Full-time">Full-time</option>
                        <option value="Part-time">Part-time</option>
                        <option value="Internship">Internship</option>
                    </select>
                </div>

                <!-- Location Type -->
                <div class="form-group">
                    <label for="jenis_lokasi">Location Type</label>
                    <select class="form-control" id="jenis_lokasi" name="jenis_lokasi" required>
                        <option value="">Select Location</option>
                        <option value="on-site">On-site</option>
                        <option value="hybrid">Hybrid</option>
                        <option value="remote">Remote</option>
                    </select>
                </div>

                <!-- Attachment Upload -->
                <div class="form-group">
                    <label for="attachments">Upload Attachments</label>
                    <input type="file" id="attachments" name="attachments[]" multiple>
                </div>

                <button type="submit" class="btn">Post Job</button>
            </form>
        </div>
    </div>

    <!-- Quill.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="../../../public/js/tambah-lowongan.js"></script>
    <script src="../../../public/js/quill-setup.js"></script>
</body>

</html>