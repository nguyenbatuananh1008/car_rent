<?php
require_once 'Database.php';

class Admin {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect(); // Kết nối cơ sở dữ liệu
    }

    public function login($email, $password) {
        // Câu lệnh SQL để lấy thông tin tài khoản admin
        $sql = "SELECT * FROM admin WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra email và mật khẩu (mật khẩu không mã hóa)
        if ($admin && $admin['password'] === $password) {
            return $admin; // Trả về thông tin admin nếu đúng
        }

        return false; 
    }
}
?>
