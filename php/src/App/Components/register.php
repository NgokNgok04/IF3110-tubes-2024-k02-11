<section class="auth-container">
    <h1>Register</h1>
    <form id="registerForm" action="/register" method="POST" class="auth-form" autocomplete="off">
        <div>
            <label>Username</label> <br>
            <input type="text" name="name" class="auth-input" placeholder="Enter your name.." autocomplete="off" required/> <br>
            <label>Email</label> <br>
            <input type="text" name="email" class="auth-input" placeholder="Enter your email.." autocomplete="off" required/> <br>

            <label>Password</label> <br>
            <input type="password" name="password" class="auth-input" placeholder="Enter your password.." autocomplete="new-password" required/> <br>
            
            <label>Role</label> <br>
            <select name="role" class="auth-select" required>
                <option value="" disabled selected>Select a Role</option>
                <option value="jobseeker">JobSeeker</option>
                <option value="company">Company</option>
            </select>
        </div>
        <div class="auth-submit-container">
            <button type="submit" class="auth-submit" name="submit">Register</button>
            <p class="register-login">Already have account? &nbsp;<a href="/login">Login</a></p>
        </div>
    </form>
</section>