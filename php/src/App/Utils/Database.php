<?php

namespace App\Utils;

class Database {
    private $host;
    private $database_name;
    private $username;
    private $password;

    private $port;
    private $connection;

    public function __construct() {
        $this->host = DB_HOST;
        $this->database_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASSWORD;
        $this->port = DB_PORT;
    }

    /**
     * 
     this function will connect to the database
     * @throws \Exception
     * @return void
     */
    public function getConnection(){
        $this->connection = pg_connect("host=$this->host dbname=$this->database_name user=$this->username password=$this->password port=$this->port");

        if (!$this->connection) {
            throw new \Exception("Could not connect to the database.");
        }
        else{
            echo "Connected to the database.\n";
        }

    }

    public function closeConnection(){
        pg_close($this->connection);
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
