<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;

class Database
{
    private $host = DB_HOST;
    private $database_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $port = DB_PORT;
    private $connection;
    private static $instance = null;

    private function __construct()
    {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->database_name}";

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function __destruct()
    {
        $this->connection = null; // Close the connection
    }

    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    public function execute($query, $params = [])
    {
        return $this->bindAndExecute($query, $params);
    }

    public function fetchAll($query, $params = [])
    {
        return $this->bindAndFetchAll($query, $params);
    }

    public function fetch($query, $params = [])
    {
        return $this->bindAndFetch($query, $params);
    }

    public function rowCount($query, $params = [])
    {
        return $this->bindAndRowCount($query, $params);
    }

    public function showTables()
    {
        try {
            $stmt = $this->connection->query("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error retrieving table list: " . $e->getMessage());
        }
    }

    public function runScript($filepath)
    {
        try {
            $script = file_get_contents($filepath);
            $this->connection->exec($script);
        } catch (PDOException $e) {
            throw new Exception("Error running script: " . $e->getMessage());
        }
    }

    // New methods for binding and executing
    private function bindAndExecute($query, $params)
    {
        try {
            $stmt = $this->prepare($query);
            $this->bindParams($stmt, $params);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error executing query: " . $e->getMessage());
        }
    }

    private function bindAndFetchAll($query, $params)
    {
        try {
            $stmt = $this->prepare($query);
            $this->bindParams($stmt, $params);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception("Error fetching all rows: " . $e->getMessage());
        }
    }

    private function bindAndFetch($query, $params)
    {
        try {
            $stmt = $this->prepare($query);
            $this->bindParams($stmt, $params);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Error fetching row: " . $e->getMessage());
        }
    }

    private function bindAndRowCount($query, $params)
    {
        try {
            $stmt = $this->prepare($query);
            $this->bindParams($stmt, $params);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Error counting rows: " . $e->getMessage());
        }
    }

    // Method to bind parameters
    private function bindParams($stmt, $params)
    {
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value); // By reference to handle updating of parameters
        }
    }
}
