<?php
// Kiểm tra nếu có từ khóa tìm kiếm
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $keyword = trim($_GET['search']); // Loại bỏ khoảng trắng thừa

    // Nếu tìm kiếm qua email (có chứa ký tự @)
    if (strpos($keyword, '@') !== false) {
        header("Location: customerList.php?search=" . urlencode($keyword));
        exit();
    }

    // Nếu tìm kiếm qua ID (chỉ gồm các số)
    if (preg_match('/^[0-9]+$/', $keyword)) {
        header("Location: staffList.php?search=" . urlencode($keyword));
        exit();
    }

    // Nếu mặc định tìm theo tên
    header("Location: customerList.php?search=" . urlencode($keyword));
    exit();
} else {
    // Nếu không có từ khóa, chuyển về trang chính (dashboard)
    header("Location: dashboard.php");
    exit();
}
?>
