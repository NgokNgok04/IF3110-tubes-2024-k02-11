<?php
require_once __DIR__ . '/App/Config/Include.php';

class AutoLoader {
    public static function loadClass() {
        // Convert namespace to full file path
        spl_autoload_register(function ($class) {
            $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($file)) {
                echo "Loading file: $file\n";
                require $file;
            } else {
                // Optionally handle cases where the file doesn't exist
                throw new Exception("File not found: $file");
            }
        });

    }
}

AutoLoader::loadClass();
/**
 * usage: 
 * make sure each file included in the autoload.php is in the correct path
 * 
 * use App\Utils\Database;
 * this usage will load the file php/src/App/Utils/Database.php
 * 
 * namespace App\Utils;
 * this namespace will be converted to php/src/App/Utils
 */