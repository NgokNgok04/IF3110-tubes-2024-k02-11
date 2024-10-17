<section class="login-container">
    <h1>Login</h1>
    <form id="loginForm" action="/login" method="POST" class="login-form" autocomplete="off">
        <label>Email</label> <br>
        <input type="email" name="email" class="login-email" placeholder="Enter your email.." autocomplete="off" required/> <br>
        
        <label>Password</label> <br>
        <input type="password" name="password" class="login-password" placeholder="Enter your password.." autocomplete="new-password" required/> <br>
        
        <input type="submit" id="submitBtn" class="login-submit" name="submit" value="Login"/>
    </form>
    <p>Don't have an account? <a href="/register"><b>Register Here</b></a>.</p>
</section>