<?php


spl_autoload_register(function ($class) {
    // Convert namespace to full file path
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($file)) {
        echo "Loading file: $file\n";
        require $file;
    } else {
        // Optionally handle cases where the file doesn't exist
        throw new Exception("File not found: $file");
    }
});

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