<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lamaran Kerja - Apply for a job at <?php echo $data['company_name']; ?> for the position of <?php echo $data['posisi']; ?>.">
    <title>Lamaran Kerja</title>
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/jobseeker/lamaran.css">
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
        <div class="company-position">
            <h1><?php echo $data['company_name']; ?></h1>
            <h1 class="connector"> - </h1>
            <h1><?php echo $data['posisi']; ?></h1>
        </div>
        <form action="/detail-lamaran/lamaran/<?php echo $data['lowongan_id']; ?>/add" method="POST" enctype="multipart/form-data">
            <label for="cv">Upload CV</label>
            <input type="file" id="cv" name="cv" accept=".pdf" required>

            <label for="video">Upload Video</label>
            <input type="file" id="video" name="video" accept=".mkv,.mp4">
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
<script>
    document.getElementById('applicationForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', this.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                window.location.href = '/detail-lowongan/<?php echo $data['lowongan_id']; ?>?status=success';
            } else {
                window.location.href = '/detail-lowongan/<?php echo $data['lowongan_id']; ?>?status=failed';
            }
        };
        xhr.send(formData);
        });
</script>

</html>