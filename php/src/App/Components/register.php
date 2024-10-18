
<section class="auth-container">
    <h1>Register</h1>
    <form id="registerForm" method="POST" class="auth-form" autocomplete="off">
        <div>
            <label>Role</label> 
            <select name="role" id="auth-role" class="auth-select">
                <option value="" disabled selected>Select a Role</option>
                <option value="jobseeker">JobSeeker</option>
                <option value="company">Company</option>
            </select>
            <span class="error-message display-none" id="error-role">Role is required</span>

            <div class="auth-form-group">
                <div class="auth-form-subgroup">
                    <label>Name</label> 
                    <input type="text" id="auth-name" name="name" class="auth-input" placeholder="Enter your name.." autocomplete="off"/> 
                    <span class="error-message display-none" id="error-name">Name is required</span>
                </div>
                <div class="auth-form-subgroup"> 
                    <label>Email</label> 
                    <input type="email" id="auth-email" name="email" class="auth-input" placeholder="Enter your email.." autocomplete="off"/> 
                    <span class="error-message display-none" id="error-email">Email is required</span>
                    <span class="error-message display-none" id="error-email-used">Email already used</span>
                </div>
            </div>
            
            <div class="auth-form-group">
                <div class="auth-form-subgroup">
                    <label>Password</label> 
                    <input type="password" id="auth-password" name="password" class="auth-input" placeholder="Enter your password.." autocomplete="new-password"/> 
                    <span class="error-message display-none" id="error-password">Password is required</span>
                </div>
                <div class="auth-form-subgroup">
                    <label>Confirm Password</label> 
                    <input type="password" id="auth-confirm-password" name="confirm-password" class="auth-input" placeholder="Enter your password.." autocomplete="new-password"/> 
                    <span class="error-message display-none" id="error-password-2" class="display-none">Password is required</span>
                    <span class="error-message display-none" id="error-confirm-password" class="display-none">Password is not match</span>
                </div>
            </div>
            <div class="auth-form-subgroup display-none" id="location-fields">
                <label>Location</label>
                <input type="text" id="auth-location" name="location" class="auth-input" placeholder="Enter your location.."/>
                <span class="error-message display-none" id="error-location">Location is required</span>
            </div>
            <div class="auth-form-subgroup display-none" id="about-fields">
                <label>About</label>
                <input type="textarea" id="auth-about" name="about" class="auth-input" placeholder="Tell us about your Company"/>
                <span class="error-message display-none" id="error-about">About is required</span>
            </div>
            
        </div>
        <div class="auth-submit-container">
            <button type="submit" class="auth-submit" name="submit">Register</button>
            <p class="register-login">Already have account? &nbsp;<a href="/login">Login</a></p>
        </div>
    </form>
</section>

<script src="../../public/js/register.js" defer></script>