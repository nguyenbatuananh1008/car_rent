<?php
class Database {
    private $host = "localhost";
    private $db_name = "dat_ve"; // Thay bằng tên cơ sở dữ liệu của bạn
    private $username = "root";
    private $password = ""; // Thay bằng mật khẩu của bạn
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
}
?>
