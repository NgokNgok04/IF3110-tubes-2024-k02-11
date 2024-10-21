<?php
function generateNavbar($type){
    ?>
    <navbar>
        <button id="logo">
            <h1 class="logo-text">Link</h1>
            <img src="../../public/images/LIP-Logo.png">
            <h1 class="logo-text">Purry</h1>
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
                <button id='nav-home-1' class="navbar-menu">
                    <i class="fa-solid fa-house"></i>
                    <p>Home</p>
                </button>
                <button id="nav-lowongan" href="/register" class="navbar-menu">
                    <i class="fa-solid fa-briefcase"></i>
                    <p>Riwayat</p>
                </button>
                
                <div class="navbar-logout">
                    <button class="navbar-menu">
                        <i class="fa-solid fa-circle-user"></i>
                        <p>Saya</p>
                    </button>
                    <div class="dropdown-content">
                    <button id="nav-logout-1">
                            <i class="fa-solid fa-power-off"></i>
                            <p>Logout</p>
                        </button>
                    </div>
                </div>
            <?php elseif ($type == 'Company'): ?>
                <button id='nav-home-2' class="navbar-menu">
                    <i class="fa-solid fa-house"></i>
                    <p>Home</p>
                </button>
                <button id="nav-com-profile" class="navbar-menu">
                    <i class="fa-solid fa-building"></i>
                    <p>Profile</p>
                </button>
                
                <div class="navbar-logout">
                    <button href="/home" class="navbar-menu">
                        <i class="fa-solid fa-circle-user"></i>
                        <p>Saya</p>
                    </button>
                    <div class="dropdown-content">
                        <button id="nav-logout-2">
                            <i class="fa-solid fa-power-off"></i>
                            <p>Logout</p>
                        </button>
                    </div>
                </div>

            <?php endif; ?>
            
        </section>
    </navbar>
    <script src="../../public/js/navbar.js" defer></script>
    <?php
}
?>