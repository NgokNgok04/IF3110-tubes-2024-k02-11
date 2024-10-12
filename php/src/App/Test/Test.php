<?php


namespace App\Test;
require_once __DIR__ . '/../Config/Include.php';

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

$test = new Test();
$test->test();