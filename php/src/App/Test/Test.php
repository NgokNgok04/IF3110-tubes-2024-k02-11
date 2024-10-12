<?php

namespace App\Test;
use App\Utils\Database;

class Test {
    public function __construct() {
        $db = new Database();
        $db->getConnection();
    }

    public function test() {
        echo "Test function called.\n";
    }
}

// Add this script to run the Test class