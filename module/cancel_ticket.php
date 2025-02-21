<?php
session_start();
require_once 'Ticket.php';  // Đảm bảo đường dẫn chính xác tới file Ticket.php

// Bao gồm file chứa lớp Ticket  // Đảm bảo đường dẫn chính xác tới file Ticket.php

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    die("Bạn cần đăng nhập để thực hiện hành động này.");
}

// Kiểm tra nếu có tham số ticketId được gửi lên
if (isset($_GET['ticketId'])) {
    $ticketId = $_GET['ticketId'];
    $userId = $_SESSION['user_id'];  // Lấy id_user từ session

    // Nếu người dùng đã xác nhận muốn hủy vé, thực hiện hủy
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // Khởi tạo đối tượng Ticket và gọi phương thức hủy vé
        $ticket = new Ticket();
        $cancelResult = $ticket->cancelTicket($ticketId, $userId); // Gọi phương thức hủy vé

        // Hiển thị thông báo và chuyển hướng về trang đơn hàng
        if ($cancelResult) {
            echo "<script>alert('Vé đã được hủy thành công.');</script>";
            // Chuyển hướng về trang đơn hàng sau 2 giây
            header("refresh:2;url=../my_order.php"); // Thay 'your_orders_page.php' bằng trang bạn muốn chuyển hướng đến
        } else {
            echo "<script>alert('Hủy vé thất bại.');</script>";
        }
    } else {
        // Nếu người dùng chưa xác nhận, hỏi người dùng có chắc chắn muốn hủy vé không
        echo "<script>
                if (confirm('Bạn có chắc chắn muốn hủy vé này không?')) {
                    window.location.href = 'cancel_ticket.php?ticketId=$ticketId&confirm=yes'; // Nếu OK, thực hiện hủy
                } else {
                    window.location.href = 'your_orders_page.php'; // Nếu Cancel, quay lại trang đơn hàng
                }
              </script>";
    }
} else {
    echo "<script>alert('Vé không tồn tại hoặc không thể hủy.');</script>";
}
?>
