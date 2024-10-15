<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div>
        <form action="/user/register" method="POST" id="registerForm">
            <!-- Username -->
            <label for="username" class="form-label">Username: </label>
            <input type="text" name="username" id="username" class="form-control" placeholder="AkuGanteng" required>

            <!-- Password -->
            <label for="password" class="form-label">Password: </label>
            <input type="password" name="password" id="password" class="form-control" placeholder="password" required>

            <!-- Type Account -->
            <label for="type" class="form-label">Type Account: </label>
            <select name="type" id="type" class="form-control" required>
                <option value="jobseeker">JobSeeker</option>
                <option value="company">Company</option>
            </select>

            <!-- Email -->
            <label for="email" class="form-label">Email: </label>
            <input type="email" name="email" id="email" class="form-control" placeholder="example@gmail.com" required>

            <!-- Register Button -->
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p>Already have an account? <a href="/user/loginPage"><b>Login Here</b></a>.</p>
    </div>
</body>
</html>
