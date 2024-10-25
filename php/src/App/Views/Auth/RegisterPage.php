<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../../../public/styles/global.css">
    <link rel="stylesheet" href="../../../public/styles/navbar.css">
    <link rel="stylesheet" href="../../../public/styles/register.css">
    <script src="https://kit.fontawesome.com/3816d0d83d.js" crossorigin="anonymous"></script>
</head>
<body>
    <div>
        <?php 
            include(__DIR__ . "/../../Components/navbar.php");
            generateNavbar('Not Login');
        ?>
        <?php
            include(__DIR__ . "/../../Components/register.php");
        ?>
    </div>
</body>
</html>
