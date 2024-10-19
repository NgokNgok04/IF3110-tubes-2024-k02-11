<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamaran Kerja</title>
    <link rel="stylesheet" href="../../../public/styles/jobseeker/lamaran.css">
</head>
<body>
    <div class="container">
        <h1><?php echo $data['company_name']; ?></h1>
        <h2><?php echo $data['posisi']; ?></h2>
        <form action="/detail-lamaran/lamaran/<?php echo $data['lowongan_id']; ?>/add" method="POST" enctype="multipart/form-data">
            <label for="cv">Upload CV:</label>
            <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>

            <label for="video">Upload Video:</label>
            <input type="file" id="video" name="video" accept=".mkv,.mp4" required>
            
            <button type="submit">Submit Application</button>
        </form>
    </div>
</body>
</html>