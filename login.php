<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kết nối tới cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'dat_ve');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT id_user, email, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Kiểm tra nếu có người dùng với email này
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Kiểm tra nếu mật khẩu trùng khớp
        if ($password == $row['password']) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $row['id_user'];
            $_SESSION['email'] = $row['email'];

            // Chuyển hướng về trang chủ
            header('Location: index.php');
            exit();
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Không tìm thấy tài khoản với email này!";
    }

    // Đóng kết nối
    $conn->close();
}
?>
