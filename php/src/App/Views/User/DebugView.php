<?php

namespace App\Views\User; 

use App\Core\View;
use App\Interfaces\ViewInterface;

class DebugView extends View{
    private $key;
    public function __construct($key, $data = []){
        $this->data = $data;
        $this->key = $key;
    }
    public function render(){
        $users = $this->data[$this->key] ?? [];
        require_once PAGES_DIR . '/User/DebugPage.php';
    }
}