<section class="login-container">
    <h1>Register</h1>
    <form id="registerForm" action="/register" method="POST" class="register-form" autocomplete="off">
        <label>Username</label> <br>
        <input type="text" name="name" class="login-email" placeholder="Enter your name.." autocomplete="off" required/> <br>

        <label>Email</label> <br>
        <input type="email" name="email" class="login-email" placeholder="Enter your email.." autocomplete="off" required/> <br>
        
        <label>Password</label> <br>
        <input type="password" name="password" class="login-password" placeholder="Enter your password.." autocomplete="new-password" required/> <br>
        
        
        <label>Type Account</label> <br>
        <select name="role" class="form-control" required>
            <option value="jobseeker">JobSeeker</option>
            <option value="company">Company</option>
        </select>
        <input type="submit" id="submitBtn" class="login-submit" name="submit" value="register"/>
    </form>
    <p>Already have an account? <a href="/login"><b>Login Here</b></a>.</p>
</section>