<?php
// Lấy dữ liệu từ form trước
$id_trip = $_POST['id_trip'] ?? null;
$pickup_location = $_POST['pickup_location'] ?? null;
$dropoff_location = $_POST['dropoff_location'] ?? null;
$ticket_quantity = $_POST['ticket_quantity'] ?? null;
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$trip_price = $_POST['trip_price'] ?? 0;
$total_price = $ticket_quantity * $trip_price;

$car_house_name = $_POST['car_house_name'] ?? null;
$city_from_name = $_POST['city_from_name'] ?? null;
$city_to_name = $_POST['city_to_name'] ?? null;
$pickup_time = $_POST['pickup_time'] ?? null;
$pickup_name = $_POST['pickup_name'] ?? null;
$dropoff_time = $_POST['dropoff_time'] ?? null;
$dropoff_name = $_POST['dropoff_name'] ?? null;
$date = $_POST['date'] ?? null; // Lấy $date từ POST
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn phương thức thanh toán</title>
</head>
<body>
<div class="container mt-4">
    <h3>Thông tin chuyến đi</h3>
    <p><strong>Ngày khởi hành:</strong> <?= htmlspecialchars($date) ?></p>
    <p>Thành phố đi : <?= htmlspecialchars($city_from_name) ?></p>
    <p>Thành phố đến     : <?= htmlspecialchars($city_to_name) ?></p>
    <p><strong>Điểm đón:</strong> <?= htmlspecialchars($pickup_name) ?> lúc <?= htmlspecialchars($pickup_time) ?></p>
    <p><strong>Điểm trả:</strong> <?= htmlspecialchars($dropoff_name) ?> lúc <?= htmlspecialchars($dropoff_time) ?></p>
    <p><strong>Nhà xe:</strong> <?= htmlspecialchars($car_house_name) ?></p>
    <p><strong>Tổng tiền:</strong> <?= number_format($total_price, 0) ?> đ</p>

    <h3>Thông tin khách hàng</h3>
    <p><strong>Họ tên:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($phone) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>

    <h3>Chọn phương thức thanh toán</h3>
    <form method="POST" action="module/process_payment.php">
        <input type="hidden" name="id_trip" value="<?= htmlspecialchars($id_trip) ?>">
        <input type="hidden" name="ticket_quantity" value="<?= htmlspecialchars($ticket_quantity) ?>">
        <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
        <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_cash" value="cash" required>
            <label class="form-check-label" for="payment_cash">Thanh toán tiền mặt</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_qr" value="qr" required>
            <label class="form-check-label" for="payment_qr">QR Code</label>
        </div>
        <button class="btn btn-primary" type="submit">Xác nhận thanh toán</button>
    </form>
</div>
</body>
</html>
