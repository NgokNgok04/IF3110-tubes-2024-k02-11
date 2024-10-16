<?php

namespace App\Views\User; 

use App\Interfaces\ViewInterface;

class DebugView implements ViewInterface {
    private $data;

    public function __construct($data = []) {
        $this->data = $data;  // Store the passed data
    }

    public function render() {
        // Make the data available inside the template
        $users = $this->data['users'] ?? []; 
        require_once PAGES_DIR . '/User/DebugPage.php';
    }
}