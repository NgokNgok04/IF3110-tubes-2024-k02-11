<?php
    if(!isset($_SESSION['user'])){
        session_destroy();
        header('Location: /User/LoginPage');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Page</title>
</head>
<body>
    <div>
        <form action="/user/logout" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div> 
</body>
</html>