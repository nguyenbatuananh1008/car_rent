<?php
require_once 'TripSearcher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_trip = $_POST['id_trip'];
    $pickup_location = $_POST['pickup_location'];
    $dropoff_location = $_POST['dropoff_location'];
    $ticket_quantity = $_POST['ticket_quantity'];
    $user_name = $_POST['name'];
    $user_phone = $_POST['phone'];
    $user_email = $_POST['email'];
    $total_price = $_POST['total_price'];
    $payment_method = $_POST['payment_method'];

    // Khởi tạo đối tượng TripSearcher
    $tripSearcher = new TripSearcher();

    // Xử lý theo phương thức thanh toán
    if ($payment_method === 'cash') {
        // Lưu vé và đặt trạng thái chưa thanh toán
        $result = $tripSearcher->createTicket([
            'id_trip' => $id_trip,
            'id_user' => $_SESSION['user_id'] ?? null,
            'name' => $user_name,
            'phone' => $user_phone,
            'email' => $user_email,
            'number_seat' => $ticket_quantity,
            'total_price' => $total_price,
            'status' => 0, // Chưa thanh toán
            'method' => 0, // Tiền mặt
        ]);
        if ($result) {
            echo "<p style='color:green;'>Đặt vé thành công! Thanh toán tại xe.</p>";
        } else {
            echo "<p style='color:red;'>Đặt vé thất bại, vui lòng thử lại.</p>";
        }
    } elseif ($payment_method === 'qr') {
        // Hiển thị QR code
        $qrUrl = "https://img.vietqr.io/image/MB-0000542277521.png?amount=$total_price&addInfo=Thanh toán vé xe&accountName=NGUYEN BA TUAN ANH";
        echo "<h3>Quét mã QR để thanh toán</h3>";
        echo "<img src='$qrUrl' alt='QR Code'>";
    } elseif ($payment_method === 'card') {
        // Hiển thị giao diện nhập thông tin thẻ
        echo "<h3>Nhập thông tin thẻ để thanh toán</h3>";
        echo "<form action='card_payment.php' method='POST'>";
        echo "<input type='hidden' name='id_trip' value='" . htmlspecialchars($id_trip) . "'>";
        echo "<input type='hidden' name='total_price' value='" . htmlspecialchars($total_price) . "'>";
        echo "<label>Số thẻ: <input type='text' name='card_number' required></label><br>";
        echo "<label>Ngày hết hạn: <input type='text' name='expiry_date' placeholder='MM/YY' required></label><br>";
        echo "<label>CVV: <input type='text' name='cvv' required></label><br>";
        echo "<button type='submit'>Thanh toán</button>";
        echo "</form>";
    }
}
?>
