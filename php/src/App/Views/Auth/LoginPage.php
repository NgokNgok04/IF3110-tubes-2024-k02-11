<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../../../public/styles/global.css">
        <link rel="stylesheet" href="../../../public/styles/navbar.css">
        <link rel="stylesheet" href="../../../public/styles/login.css">
      http://localhost:8000/detail-lowongan/10?status=success
        <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <div>
            <?php 
                include(__DIR__ . "/../../Components/navbar.php"); 
                generateNavbar('Not Login')?>
            <?php
                include(__DIR__ . "/../../Components/login.php");
            ?>
        </div>
    </body>
</html>