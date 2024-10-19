<?php
function generateNavbar($type){
    ?>
    <navbar>
        <button id="logo">
            <h1>Link</h1>
            <img src="../../public/images/LIP-Logo.png">
            <h1>Purry</h1>
        </button>

        <section>
            <?php if ($type == 'Not Login'):?>
                <a href="/login" class="navbar-login">
                    Login
                </a>
                <a href="/register" class="navbar-register">
                    Register
                </a>
            <?php elseif ($type == 'JobSeeker'): ?>
                <button href="/register" class="navbar-menu">
                    <i class="fa-solid fa-house"></i>
                    <p>Home</p>
                </button>
                <button href="/register" class="navbar-menu">
                    <i class="fa-solid fa-briefcase"></i>
                    <p>Lowongan</p>
                </button>
                
                <div class="navbar-logout">
                    <button href="/home" class="navbar-menu">
                        <i class="fa-solid fa-circle-user"></i>
                        <p>Saya</p>
                    </button>
                    <div class="dropdown-content">
                        <a bref='logout'>Logout</a>
                    </div>
                </div>

            <?php endif; ?>
            
        </section>
    </navbar>
    <script src="../../public/js/navbar.js" defer></script>
    <?php
}
?>