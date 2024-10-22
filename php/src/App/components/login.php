
<?php 
    include(__DIR__ . '/error-toast.php');
    generateErrorToast();
?>
<section class="auth-container">
    <h1>Login</h1>
    <form id="loginForm" method="POST" action="/login" class="auth-form" autocomplete="off">
        <div>
            <div class="auth-form-group">
                <div class="auth-form-subgroup"> 
                    <label>Email</label> 
                    <input type="email" id="auth-email" name="email" class="auth-input" placeholder="Enter your email.." autocomplete="off"/> 
                    <span class="error-message display-none" id="error-email">Email is required</span>
                </div>
            </div>
            <div class="auth-form-group">    
                <div class="auth-form-subgroup">
                    <label>Password</label> 
                    <input type="password" id="auth-password" name="password" class="auth-input" placeholder="Enter your password.." autocomplete="new-password"/> 
                    <span class="error-message display-none" id="error-password">Password is required</span>
                </div>
            </div>
        </div>
        <div class="auth-submit-container">
            <button type="submit" class="auth-submit" name="submit">Login</button>
            <p class="register-login">Dont have account? &nbsp;<a href="/register">Register</a></p>
        </div>
    </form>
</section>

<script src="../../public/js/login.js" defer></script>