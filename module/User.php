<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM user WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin người dùng nếu đăng nhập thành công
    }
    public function register($name, $email, $password) {
        // Kiểm tra xem email đã tồn tại chưa
        $sql = "SELECT id_user FROM user WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false; // Email đã tồn tại
        }

        // Thêm người dùng mới
        $sql = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        // Không mã hóa mật khẩu để đảm bảo yêu cầu
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }
}
?>
