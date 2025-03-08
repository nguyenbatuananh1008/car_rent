<?php
session_start();
require_once 'Ticket.php'; // Đảm bảo đường dẫn chính xác

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để thực hiện hành động này.");
}

// Kiểm tra tham số ticketId
if (!isset($_GET['ticketId'])) {
    die("Vé không tồn tại hoặc không thể hủy.");
}

$ticketId = $_GET['ticketId'];
$userId = $_SESSION['user_id']; 

$ticket = new Ticket();

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    // Hủy vé ngay lập tức nếu đã xác nhận
    if ($ticket->cancelTicket($ticketId, $userId)) {
        header("Location: ../my_order.php?msg=success"); // Chuyển hướng nhanh về trang đơn hàng
        exit();
    } else {
        header("Location: ../my_order.php?msg=error"); // Chuyển hướng nếu hủy thất bại
        exit();
    }
}

// Nếu chưa xác nhận, hiển thị thông báo xác nhận qua URL
header("Location: cancel_ticket.php?ticketId=$ticketId&confirm=yes");
exit();
