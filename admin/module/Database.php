<?php
class Database {
    private $host = "localhost"; // Địa chỉ server
    private $username = "root"; // Tài khoản MySQL
    private $password = ""; // Mật khẩu MySQL
    private $database = "dat_ve"; // Tên database
    public $conn;

    // Kết nối đến cơ sở dữ liệu
    public function connect() { 
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Kết nối thất bại: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
