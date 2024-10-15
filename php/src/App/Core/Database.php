<?php

namespace App\Core;

class Database {
    private $host = DB_HOST;
    private $database_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $port = DB_PORT;
    private $connection;
    private static $instance = null;

    public function __construct() {
        // echo "connected to database";
        // echo $this->host . "\n"; 
        // echo $this->database_name . "\n"; 
        // echo $this->username . "\n"; 
        // echo $this->port . "\n";
        // echo $this->password . "\n";
        $this->connection = pg_connect("host=$this->host dbname=$this->database_name user=$this->username password=$this->password port=$this->port");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function __destruct(){
        // echo "closed database";
        pg_close($this->connection);
    }

    public function execute($query, $params = []){
        $result = pg_prepare($this->connection, "", $query);
        $result = pg_execute($this->connection, "", $params);
        if(!$result){
            throw new \Exception("Error executing query: " . pg_last_error($this->connection));
        }
        return $result;
    }

    public function fetchAll($query, $params = []){
        $result = pg_prepare($this->connection, "", $query);
        $result = pg_execute($this->connection, "", $params);
        if(!$result) throw new \Exception("Error fetching all.");
        else{
            return pg_fetch_all($result);
        }
    }

    public function fetch($query, $params = []) {
        $result = pg_prepare($this->connection, "", $query);
        $result = pg_execute($this->connection, "", $params);
        if (!$result) {
            throw new \Exception("Error fetching.");
        } else {
            $data = [];
            while ($row = pg_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function rowCount($query, $params = []) {
        $result = pg_query_params($this->connection, $query, $params);
        if(!$result) throw new \Exception("Error counting rows.");
        else{
            return pg_num_rows($result);
        }
    }


    //show tables debugging
    public function showTables(){
        $query = "SELECT * FROM users";
        $result = pg_query($this->connection, $query);
        if (!$result) { 
            throw new \Exception("Error executing query to show tables.");
        }
        $tables = pg_fetch_all($result);
        return $tables;
    }
}
