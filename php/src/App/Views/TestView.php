<?php 

namespace App\Views; 


class TestView{
    public function render(){
        require_once __DIR__ . '/../pages/TestPage.php';
    }
}