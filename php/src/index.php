<?php
include('App/components/navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/styles/global.css">
    <link rel="stylesheet" href="public/styles/navbar.css">
    <link rel="stylesheet" href="public/styles/login.css">
    <title>Document</title>
</head>
<body>
    <?php generateNavbar('Not Login');?>
    <?php include('App/components/login.php')?>
</body>
</html>
<?php

?>