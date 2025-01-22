<?php
class Database {
    private $host = 'localhost'; // Địa chỉ máy chủ (thường là localhost)
    private $dbname = 'dat_ve'; // Tên cơ sở dữ liệu
    private $username = 'root'; // Tên đăng nhập MySQL
    private $password = ''; // Mật khẩu MySQL
    private $conn;

    public function connect() {
        if ($this->conn == null) {
            try {
                // Kết nối đến cơ sở dữ liệu bằng PDO
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Hiển thị lỗi dạng Exception
            } catch (PDOException $e) {
                // Nếu có lỗi khi kết nối, thông báo lỗi và kết thúc chương trình
                die("Kết nối CSDL thất bại: " . $e->getMessage());
            }
        }
        return $this->conn; // Trả về kết nối PDO
    }
}
?>
