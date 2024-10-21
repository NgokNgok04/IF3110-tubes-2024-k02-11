<?php
$data = $data['lowongan'] ?? [];
// var_dump($data);    
// var_dump($data['lamaran_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detail page of Job for JobSeekers.">
    <link rel="stylesheet" href="../../../public/styles/jobseeker/detaillowongan.css">
    <title>Detail-Lowongan</title>
</head>

<body>
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
            <?php if(!isset($data['lamaran_id']) && ($data['is_open'] === True)): ?>
                <div class="application-not-applied">
                    <p>You have not applied for this position yet. <a href="/detail-lowongan/lamaran/<?php echo $lowongan['lowongan_id'];?>" class="btn">Apply</a></p>
                </div>
            <?php elseif(isset($data['lamaran_id'])): ?>
                <h3>Your Application</h3>
                <div class="application-applied">
                    <?php 
                    // echo "CV Path: " . $data['cv_path'];
                    // if(file_exists($data['cv_path'])){
                    //     echo "File exists";
                    // } else {
                    //     echo "File does not exist";
                    // }
                    ?>
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