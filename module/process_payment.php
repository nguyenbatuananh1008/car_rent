<?php
require_once 'TripSearcher.php';

// Khởi tạo đối tượng TripSearcher
$tripSearcher = new TripSearcher();

// Lấy dữ liệu từ form
$id_trip = $_POST['id_trip'] ?? null;
$user_id = $_POST['user_id'] ?? null; // Nếu chưa đăng nhập, sẽ là null
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$ticket_quantity = $_POST['ticket_quantity'] ?? 1;
$total_price = $_POST['total_price'] ?? 0;
$method = $_POST['method'] ?? 0; // 0: Thanh toán tại xe, 1: Thẻ quốc tế, 2: QR
$status = ($method == 1) ? 1 : 0; // Nếu thẻ quốc tế, trạng thái là 1 (đã thanh toán), ngược lại là 0
$date = $_POST['date'] ?? date("Y-m-d"); // Ngày hiện tại hoặc từ form

// Chuẩn bị dữ liệu để lưu
// Chuẩn bị dữ liệu để lưu
$data = [
    'id_trip' => $id_trip,
    'id_user' => $user_id ?: null, // Nếu $user_id là null, truyền null
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'number_seat' => $ticket_quantity,
    'total_price' => $total_price,
    'status' => $status,
    'method' => $method,
    'date' => $date,
];


// Gọi hàm createTicket để lưu dữ liệu
$result = $tripSearcher->createTicket($data);

// Hiển thị kết quả
if ($result) {
    echo "
    <script>
        alert('Đặt vé thành công!');
        window.location.href = '../index.php';
    </script>
    ";  
} else {
    echo "<p>Lỗi khi đặt vé. Vui lòng thử lại.</p>";
    echo "<a href='javascript:history.back()'>Quay lại</a>";
}
?>
