<?php
function generateNavbar($type){
    ?>
    <navbar>
        <a>Home</a>
        <?php
            if ($type == 'Company'){
                echo '<a>Profile</a>';
            } else if ($type == 'Job Seeker'){
                echo '<a>Riwayat</a>';
            } else if ($type == 'Not Login'){
                echo '<a>Login</a>';
                echo '<a>Register</a>';
            }
        ?>
    </navbar>
    <?php 
}
?>