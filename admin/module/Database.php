<?php
class Database {
    private $host = "localhost";
    private $db_name = "dat_ve"; 
    private $username = "root";
    private $password = ""; 
    private $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    public function connectBee() {
        $this->conn = null;
    
        
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
    
        
        if ($this->conn->connect_error) {
            die("Connection error: " . $this->conn->connect_error);
        }
    
        return $this->conn;
    }
}
?>
