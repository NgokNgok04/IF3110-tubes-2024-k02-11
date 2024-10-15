<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>
<body>
    <div>
        <!-- username -->
        <label for="username" class="form-label">Username: </label>
        <input type="text" name="username" id="username" class="form-control" placeholder="AkuGanteng" required>
        <!-- password -->

        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="password" required>
        <!-- login button -->
        <button type="submit" class="btn btn-primary" id = "submitButton">Login</button>

        <p>Don't have an account? <a href="<?= BASE_URL ?>/../user/registerPage"><b>Sign Up Here</b></a>.</p>
    </div>
</body>
<script>
    submitButton = document.getElementById("submitButton");
    submitButton.addEventListener("click", function (event) {
        event.preventDefault();
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        let data = {
            username: username,
            password: password
        };

        const form = document.createElement("form");
        form.action = "/user/login";
        form.method = "POST";
        form.submit();
    });
</script>
</html>