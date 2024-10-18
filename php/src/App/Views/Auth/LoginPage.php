<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../../../public/styles/global.css">
        <link rel="stylesheet" href="../../../public/styles/navbar.css">
        <link rel="stylesheet" href="../../../public/styles/login.css">
        <link>
        
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