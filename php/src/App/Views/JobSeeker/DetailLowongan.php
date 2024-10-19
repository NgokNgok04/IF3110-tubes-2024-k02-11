<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="job-detail.css">
    <title>LinkedPurr</title>
</head>
<body>
    <div class="container">
        <div class="company-profile">
            <h2 class="company-name"><?php echo htmlspecialchars($company['company_name']); ?></h2>
            <p class="company-location"><?php echo htmlspecialchars($company['lokasi']); ?></p>
            <p class="company-about"><?php echo htmlspecialchars($company['about']); ?></p>
        </div>
        <hr>
        <div class="job-detail">
            <h2 class="job-title"><?php echo htmlspecialchars($lowongan['posisi']); ?></h2>
            <p class="job-description"><strong>Job Description:</strong> <?php echo htmlspecialchars($lowongan['deskripsi']); ?></p>
            <p><strong>Job Type:</strong> <?php echo htmlspecialchars($lowongan['jenis_pekerjaan']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($lowongan['jenis_lokasi']); ?></p>
            <p><strong>Status:</strong> <?php echo $lowongan['is_open'] ? 'Open' : 'Closed'; ?></p>
        </div>
        <hr>
        <div class="application-status">
            <h3>Your Application</h3>
            <?php
            ?>
            <?php if (
                !isset($lamaran['lowongan_id']) && ($lowongan['is_open'] === True)
            ): ?>
                <div class="application-not-applied">
                    <p>You have not applied for this position yet. <a href="/detail-lowongan/lamaran/<?php echo $lowongan['lowongan_id'];?>" class="btn">Apply</a></p>
                </div>
            <?php elseif(
                isset($lamaran['lowongan_id'])
            ): ?>
                <div class="application-applied">
                    <p>Status: <strong> <?php echo htmlspecialchars($lamaran['status']); ?></strong></p>
                    <a href="<?php echo htmlspecialchars($lamaran['cv_path']); ?>" class="attachment">Download CV</a>
                    <a href="<?php echo htmlspecialchars($lamaran['video_path']); ?>" class="attachment">Watch Introduction Video</a>
                    <p>Reason: <strong><?php echo htmlspecialchars($lamaran['status_reason'] ?? "-"); ?></strong></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>