<?php
session_start();

function checkAccess($requiredType) {
    // Kiểm tra nếu chưa đăng nhập
    if (!isset($_SESSION['usertype'])) {
        echo "<script>alert('Bạn cần đăng nhập để truy cập trang này.'); window.location.href='../views/login.php';</script>";
        exit();
    }

    // Kiểm tra nếu usertype không đủ quyền
    if ($_SESSION['usertype'] < $requiredType) {
        echo "<script>alert('Chỉ quản trị viên mới có quyền truy cập trang này.'); window.history.back();</script>";
        exit();
    }
}
?>
