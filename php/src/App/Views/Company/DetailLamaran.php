<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Details </title>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/company/detailLamaran.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../public/styles/errorToast.css">
    <link rel="stylesheet" href="../../../public/styles/successToast.css">
</head>

<body>
    <?php
    include(APP_DIR . '/components/error-toast.php');
    include(APP_DIR . '/components/success-toast.php');
    generateErrorToast();
    generateSuccessToast();
    ?>

    <main>
        <section class="cv-and-video">
            <h1>Introduction Video</h1>
            <?php if (!empty($lamaran['video_path'])): ?>
                <video class="video-frame" controls>
                    <source src="<?= htmlspecialchars($lamaran['video_path']) ?>" type="video/mp4">
                </video>
            <?php else: ?>
                <h1 id="not-found-video">Video not found</h1>
            <?php endif; ?>
            <h1>CV Applicant</h1>
            <?php if (!empty($lamaran['cv_path'])): ?>
                <iframe class="cv-frame" src="<?= htmlspecialchars($lamaran['cv_path']) ?>">
                </iframe>
            <?php else: ?>
                <h1 id="not-found-CV">CV not found</h1>
            <?php endif; ?>
        </section>
        <section class="information-section">
            <h1 class="lamaran-title">Applicant Detail</h1>
            <div class="lamaran-detail">
                <div class="lamaran-question">
                    <p>Name</p>
                    <p>Email</p>
                    <p class="lamaran-status">Status</p>
                </div>
                <div class="lamaran-answer">
                    <p>: <?= htmlspecialchars($jobseeker['nama']) ?></p>
                    <p>: <?= htmlspecialchars($jobseeker['email']) ?></p>
                    <div class="lamaran-status-btn">
                        <p>: <?= htmlspecialchars($lamaran['status']) ?></p>
                        <?php if ($lamaran['status'] === 'waiting'): ?>
                            <button id="change-button">Change</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="lamaran-reason-container">
                <?php if (!empty($lamaran['status_reason'])): ?>
                    <p class="lamaran-reason">Reason :</p>
                <?php endif; ?>
                <?php if (!empty($lamaran['status_reason'])): ?>
                    <div><?= htmlspecialchars_decode($lamaran['status_reason']) ?></div>
                <?php endif; ?>
            </div>

            <div id="myModal" class="modal display-none">
                <div class="modal-content" id="modalContent">
                    <button class="close" id="close-modal">
                        <img src="../../../public/icons/close.png" class="back-logo">
                    </button>
                    <h1 class="modal-title">Change Applicant Status</h1>
                    <form id="proses-lamaran-form" class="modal-form">
                        <div class="form-question">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" required>
                                    <option value="accepted">Accept</option>
                                    <option value="rejected">Reject</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Status Reason</label>
                                <div id="status-reason-container" class="editor"></div>
                                <input type="hidden" name="status_reason" id="status-reason">
                            </div>
                        </div>
                        <button class="form-submit" type="submit">Send</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php
    include(__DIR__ . "/../../Components/navbar.php");
    generateNavbar('Company') ?>
    <div id="modalOverlay" class="modal-overlay display-none"></div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script src="../../../public/js/detail-lamaran.js"></script>
    <script src="../../../public/js/quill-setup.js"></script>
    <script src="../../../public/js/toast.js"></script>
</body>

</html>