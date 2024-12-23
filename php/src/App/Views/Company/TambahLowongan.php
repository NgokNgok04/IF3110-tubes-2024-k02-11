<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page to Update Jobs">
    <title>Add Job</title>

    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/company/edit-lowongan.css">
    <link rel="stylesheet" href="../../../public/styles/errorToast.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
</head>

<body>
    <aside>
        <?php
        include(APP_DIR . '/components/error-toast.php');
        generateErrorToast();
        $errorMessage = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']);
        ?>

        <div hidden id="session-data" data-error-message="<?php echo $errorMessage ?>">
        </div>
    </aside>

    <?php
    include(__DIR__ . "/../../Components/navbar.php");
    generateNavbar('Company')
        ?>


    <main>
        <div class="card">
            <h1 class="title">Add Job</h1>

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
    </main>

    <!-- Quill.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="../../../public/js/tambah-lowongan.js"></script>
    <script src="../../../public/js/toast.js"></script>
    <script src="../../../public/js/quill-setup.js"></script>
</body>

</html>