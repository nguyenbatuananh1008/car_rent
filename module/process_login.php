<?php
session_start();
require_once 'db.php';
require_once 'User.php';

// Tạo kết nối và khởi tạo lớp User
$db = new Database();
$conn = $db->connect();
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Kiểm tra thông tin nhập vào
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin!']);
        exit;
    }

    // Xử lý đăng nhập
    $result = $user->login($email, $password);

    if ($result) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $result['id_user'];
        $_SESSION['user_name'] = $result['name'];
        $_SESSION['user_email'] = $result['email'];

        echo json_encode(['success' => true, 'message' => 'Đăng nhập thành công!', 'user' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email hoặc mật khẩu không đúng!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
}
?>
