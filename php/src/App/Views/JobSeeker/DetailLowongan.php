<?php
$date = $data['date'] ?? [];
$data = $data['lowongan'] ?? [];    
$dateTime = new DateTime($date['created_at']);
// var_dump($data);

// Initialize status message variable
$statusMessage = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $statusMessage = 'Your application has been submitted successfully!';
    } elseif ($_GET['status'] === 'failed') {
        $statusMessage = 'There was an error submitting your application. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail page of Job for JobSeekers.">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../public/styles/jobseeker/detaillowongan.css">
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <title>Detail-Lowongan</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($statusMessage): ?>
                alert(<?php echo json_encode($statusMessage); ?>);
            <?php endif; ?>
        });
    </script>
</head>

<body>
    <?php 
        include(__DIR__ . '/../../Components/navbar.php');
        if(isset($_SESSION['role']) && $_SESSION['role'] == 'jobseeker') {
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
            <p class="job-description"><strong>Job Description:</strong> <?php echo htmlspecialchars($data['deskripsi']); ?></p>
            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($data['jenis_pekerjaan']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($data['jenis_lokasi']); ?></p>
            <p><strong>Status:</strong> <?php echo $data['is_open'] ? 'Open' : 'Closed'; ?></p>
        </section>
        <hr>
        <section class="application-status">
            <?php if(!isset($data['lamaran_id']) && ($data['is_open'] === true)): ?>
                <div class="application-not-applied">
                    <p>You have not applied for this position yet. <a href="/detail-lowongan/lamaran/<?php echo $lowongan['lowongan_id'];?>" class="apply-btn">Apply</a></p>
                </div>
            <?php elseif(isset($data['lamaran_id'])): ?>
                <h3>Your Application</h3>
                <div class="application-applied">
                    <p>Posted on: <strong><?php echo htmlspecialchars($dateTime->format('Y-m-d H:i:s')); ?></strong></p>
                    <p>Status: <strong><?php echo htmlspecialchars($data['status']); ?></strong></p>

                    <div class="cv-container">
                        <p><strong>CV:</strong></p>
                        <iframe src="<?php echo htmlspecialchars($data['cv_path']); ?>" 
                                width="100%" height="500px" style="border: 1px solid #ccc;">
                            Your browser does not support iframes. 
                            <a href="<?php echo htmlspecialchars($data['cv_path']); ?>">Download CV</a>
                        </iframe>
                    </div>

                    <div class="video-container">
                        <p><strong>Introduction Video:</strong></p>
                        <video controls width="100%" height="400px">
                            <source src="<?php echo htmlspecialchars($data['video_path']); ?>" type="video/mp4">
                            Your browser does not support the video tag. 
                            <a href="<?php echo htmlspecialchars($data['video_path']); ?>">Watch Introduction Video</a>
                        </video>
                    </div>

                    <p>Reason: <strong><?php echo htmlspecialchars($data['status_reason'] ?? "-"); ?></strong></p>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
