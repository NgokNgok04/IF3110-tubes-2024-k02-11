<?php
    echo $_SESSION['role'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamaran Kerja</title>
</head>
<body>
    <h1>Form Pengiriman Lamaran Kerja</h1>
    <form action="submit_lamaran.php" method="POST" enctype="multipart/form-data">
        <label for="nama">Nama Lengkap:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="posisi">Posisi yang Dilamar:</label><br>
        <input type="text" id="posisi" name="posisi" required><br><br>

        <label for="cv">Unggah CV:</label><br>
        <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required><br><br>

        <label for="surat_lamaran">Unggah Surat Lamaran:</label><br>
        <input type="file" id="surat_lamaran" name="surat_lamaran" accept=".pdf,.doc,.docx" required><br><br>

        <button type="submit">Kirim Lamaran</button>
    </form>
</body>
</html>