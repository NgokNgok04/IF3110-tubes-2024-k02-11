<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details </title>
    <link rel="stylesheet" href="../../../public/styles/company/detail-lamaran.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
</head>

<body>
    <header>
        <h1>Application Details</h1>
    </header>

    <section>
        <h2>Job Seeker Data</h2>
        <p>Name: <?= htmlspecialchars($jobseeker['nama']) ?></p>
        <p>Email: <?= htmlspecialchars($jobseeker['email']) ?></p>

        <h2>Application Attachment</h2>
        <h3>CV</h3>
        <iframe src="<?= htmlspecialchars($lamaran['cv_path']) ?>" width="600" height="500" frameborder="0">
        </iframe>

        <?php if (!empty($lamaran['video_path'])): ?>
            <h3>Introduction Video</h3>
            <video width="600" controls>
                <source src="<?= htmlspecialchars($lamaran['video_path']) ?>" type="video/mp4">
            </video>
        <?php endif; ?>

        <h2>Application Status</h2>
        <p>Status: <?= htmlspecialchars($lamaran['status']) ?></p>
        <?php if (!empty($lamaran['status_reason'])): ?>
            <p>Status Reason <?= htmlspecialchars($lamaran['status_reason']) ?></p>
        <?php endif; ?>

        <?php if ($lamaran['status'] === 'waiting'): ?>
            <h2>Follow Up</h2>
            <form id="proses-lamaran-form">
                <div class="form-group">
                    <label for="status">Select Status:</label>
                    <select name="status" id="status" required>
                        <option value="accepted">Accept</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Job Description</label>
                    <div id="status-reason-container" class="editor"></div>
                    <input type="hidden" name="status_reason" id="status-reason">
                </div>

                <button type="submit">Send Follow Up</button>
            </form>
        <?php endif; ?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="../../../public/js/detail-lamaran.js"></script>
    <script src="../../../public/js/quill-setup.js"></script>
</body>

</html>