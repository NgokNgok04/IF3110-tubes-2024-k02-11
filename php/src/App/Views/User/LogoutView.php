<?php 

namespace App\Views\User;
use App\Interfaces\ViewInterface; 

class LogoutView implements ViewInterface{
    public function render(){
        require_once PAGES_DIR . '/User/LogoutPage.php';
    }
}