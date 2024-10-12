<?php

namespace App\Test;
use App\Utils\Database;

class Test {
    public function __construct() {
        $db = new Database();
    }

    public function test() {
        echo "Test function called.\n";
    }
}
