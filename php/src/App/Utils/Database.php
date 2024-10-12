<?php

namespace App\Utils;

class Database {
    private $host = DB_HOST;
    private $database_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASSWORD;

    private $port = DB_PORT;
    private $connection = null;

    public function __construct() {
        $this->connection = pg_connect("host=$this->host dbname=$this->database_name user=$this->username password=$this->password port=$this->port");
    }

    public function __destruct(){
        echo "closed database";
        $this->connection = pg_close($this->connection);
    }

    public function showResult($result){
        if(!$result){
            throw new \Exception("Error showing result.");
        }
        else{
            $tables = pg_fetch_all($result);
            return $tables;
        }
    }

    /**
     * 
     this function will execute a query with and without parameters
     e.g 
        - without params
        * $query = "SELECT * FROM users WHERE id = $1";
        this function will execute the query and return the result
        
        - with params
        *$query = "INSERT INTO users (nama, email, role, password) VALUES ($1, $2, $3, $4)";
        *    $params = [
        *       'JohnLocA',
        *       'john.LocAAAAAA@example.com',
        *        'jobseeker',
        *       'password1234'
        *   ];
        this function will insert into the users table with values in the params array
     * @param mixed $query
     * @param mixed $params
     * @throws \Exception
     * @return array|bool
     */
    public function executeQuery($query, $params = []){
        $result = pg_prepare($this->connection, "", $query);
        $result = pg_execute($this->connection, "", $params);

        if(!$result) throw new \Exception("Error executing query.");
        else echo "Query executed successfully.\n";
    }

    public function fetchAll($query, $params = []){
        $result = pg_prepare($this->connection, "", $query);
        $result = pg_execute($this->connection, "", $params);
        if(!$result) throw new \Exception("Error fetching all.");
        else{
            $tables = pg_fetch_all($result);
            return $tables;
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
