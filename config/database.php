<?php

class Database 
{
    private $host = "localhost";
    private $dbName = "ecommerce";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try{
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName}", 
                $this->username, 
                $this->password);
            // $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}