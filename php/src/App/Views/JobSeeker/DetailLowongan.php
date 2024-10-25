<?php
include(APP_DIR . '/components/success-toast.php');
include(APP_DIR . '/components/error-toast.php');
$date = $data['date'] ?? [];
$data = $data['lowongan'] ?? [];
if ($date) {
    $dateTime = new DateTime($date['created_at']);
}
// var_dump($data);

// Initialize status message variable
$statusMessage = '';

if (isset($_GET['status']) && (isset($_SESSION['success_message']) || isset($_SESSION['error_message']))) {
    generateSuccessToast();
    generateErrorToast();
    $statusMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : $_SESSION['error_message'];
    $ifSuccess = isset($_SESSION['success_message']);
    unset($_SESSION['success_message']);
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail page of Job for JobSeekers.">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/successToast.css">
    <link rel="stylesheet" href="../../../public/styles/errorToast.css">
    <link rel="stylesheet" href="../../../public/styles/jobseeker/detaillowongan.css">

    <title>Detail-Lowongan</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($statusMessage && $ifSuccess): ?>
                showSuccessToast("<?php echo $statusMessage; ?>", 3000);
            <?php endif; ?>
            <?php if ($statusMessage && !$ifSuccess): ?>
                showErrorToast("<?php echo $statusMessage; ?>", 3000);
            <?php endif; ?>
        });
    </script>
</head>

<body>
    <?php
    include(__DIR__ . '/../../Components/navbar.php');
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'jobseeker') {
        generateNavbar('JobSeeker');
    } else {
        generateNavbar('Not Login');
    }
    ?>

    <div class="container">
        <section class="company-profile">
            <h2 class="company-name"><?php echo htmlspecialchars($data['company_name']); ?></h2>
            <p class="company-location"><?php echo htmlspecialchars($data['lokasi']); ?></p>
            <p class="company-about"><?php echo htmlspecialchars($data['about']); ?></p>
        </section>
        <hr>
        <section class="job-detail">
            <h2 class="job-title"><?php echo htmlspecialchars($data['posisi']); ?></h2>
            <p class="job-description"><strong>Job Description:</strong>
                <?php echo htmlspecialchars($data['deskripsi'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($data['jenis_pekerjaan']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($data['jenis_lokasi']); ?></p>
            <p><strong>Status:</strong> <?php echo $data['is_open'] ? 'Open' : 'Closed'; ?></p>
            <p><strong>Document: </strong></p>
            <ul>
                <li>
                    <?php
                    if(isset($data['cv_path'])):
                    ?>
                        <a href="<?php echo $data['cv_path']; ?>" class="hyperlink" target="_blank">Your Application</a>
                    <?php endif; ?>
                </li>
                <li>
                    <?php
                    if(isset($data['video_path'])):
                    ?>
                        <a href="<?php echo $data['video_path']; ?>" class = "hyperlink" target="_blank">Your Introduction Video</a>
                    <?php endif; ?>
                </li>
            </ul>
        </section>
        <hr>
        <section class="application-status">
            <?php if (!isset($data['lamaran_id']) && ($data['is_open'] === true)): ?>
                <div class="application-not-applied">
                    <p>You have not applied for this position yet. <a
                            href="/detail-lowongan/lamaran/<?php echo $lowongan['lowongan_id']; ?>"
                            class="apply-btn">Apply</a></p>
                </div>
            <?php elseif (isset($data['lamaran_id'])): ?>
                <h3>Your Application</h3>
                <div class="application-applied">
                    <p>Posted on: <strong><?php echo htmlspecialchars($dateTime->format('Y-m-d H:i:s')); ?></strong></p>
                    <p>Status: <strong><?php echo htmlspecialchars($data['status']); ?></strong></p>

                    <div class="cv-container">
                        <p><strong>CV:</strong></p>
                        <iframe src="<?php echo htmlspecialchars($data['cv_path']); ?>" width="100%" height="500px"
                            style="border: 1px solid #ccc;">
                            Your browser does not support iframes.
                            <a href="<?php echo htmlspecialchars($data['cv_path']); ?>">Download CV</a>
                        </iframe>
                    </div>

                    <div class="video-container">
                        <?php
                        if (isset($data['video_path']) && $data['video_path'] !== null):
                            ?>
                            <p><strong>Introduction Video:</strong></p>
                            <video controls width="100%" height="400px">
                                <source src="<?php echo htmlspecialchars($data['video_path']); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                                <a href="<?php echo htmlspecialchars($data['video_path']); ?>">Watch Introduction Video</a>
                            </video>
                        <?php else: ?>
                            <p><strong>No introduction video available.</strong></p>
                        <?php endif; ?>
                    </div>
                    <p>Reason: <strong><?php echo $data['status_reason'] ?? "-"; ?></strong></p>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
<script>
    function showSuccessToast(message) {
        const successToast = document.getElementById("success-toast");
        const successMessage = document.getElementById("success-message-content");
        if (successToast && message) {
            successMessage.innerText = message;
            setTimeout(() => {
                successToast.classList.add("show-initial"); = "70px";
                successToast.classList.remove("hide");
                setTimeout(() => {
                    successToast.classList.add("hide");
                }, 5000);
            }, 500); // 0.5-second delay
        }
    }

    function showErrorToast(message) {
        const errorToast = document.getElementById("error-toast");
        const errorMessage = document.getElementById("error-message-content");
        if (errorToast && message) {
            errorMessage.innerText = message;
            setTimeout(() => {
                errorToast.classList.add("show-initial"); = "70px";
                errorToast.classList.remove("hide");
                setTimeout(() => {
                    errorToast.classList.add("hide");
                }, 5000);
            }, 500);
        }
    }
</script>

</html>