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
    public function getUserInfo($id_user) {
        // Truy vấn để lấy thông tin người dùng
        $sql = "SELECT name, email FROM user WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();
        
        // Trả về thông tin người dùng dưới dạng mảng associative
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id_user, $name, $email) {
        // Cập nhật tên người dùng
        $sql = "UPDATE user SET name = :name, email = :email WHERE id_user = :id_user";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_user', $id_user);

        return $stmt->execute(); // Trả về true nếu cập nhật thành công
    }
}
?>
