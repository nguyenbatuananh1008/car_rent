<?php
session_start();
include 'db.php';
include 'User.php';

// Tạo kết nối và khởi tạo lớp User
$db = new Database();
$conn = $db->connect();
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Xử lý đăng nhập
    $result = $user->login($email, $password);

    if ($result) {
        $_SESSION['user_id'] = $result['id_user'];
        $_SESSION['user_name'] = $result['name'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email hoặc mật khẩu không đúng!']);
    }
}
?>
