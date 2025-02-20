<?php
session_start();

// Kiểm tra nếu có thông tin vé trong session
if (isset($_SESSION['ticket_info'])) {
    $ticket_info = $_SESSION['ticket_info'];
} else {
    die("Không có thông tin vé để hiển thị.");
}

// Lấy thông tin vé từ session
$id_trip = $ticket_info['id_trip'];
$name = $ticket_info['name'];
$phone = $ticket_info['phone'];
$email = $ticket_info['email'];
$number_seat = $ticket_info['number_seat'];
$total_price = $ticket_info['total_price'];
$status = $ticket_info['status'];
$method = $ticket_info['method'];
$date = $ticket_info['date'];
$car_name = $ticket_info['car_name'];
$car_house_name = $ticket_info['car_house_name'];
$pickup_location = $ticket_info['pickup_location'];
$dropoff_location = $ticket_info['dropoff_location'];
$pickup_time = $ticket_info['pickup_time'];
$car_capacity = $ticket_info['car_capacity'];
$car_type = $ticket_info['car_type'];
$car_image = $ticket_info['car_image'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin đặt vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
    <?php 
    include "layout/header.php";  // Đảm bảo header đã được bao gồm ở đây
    ?>

<body>
    
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="container">
    <a href="index.php" class="text-decoration-none text-primary mb-3 d-block">&larr; Trang chủ</a>
        <h1 class="text-success mb-4">Đặt vé thành công</h1>
        <div class="alert alert-danger" role="alert">
            Lưu ý: Vui lòng lưu lại thông tin thanh toán này.
        </div>

        <!-- Button để chụp lại thông tin -->
        <button class="btn btn-success mb-4" onclick="window.print();">Chụp lại thông tin vé</button>

        <!-- Thông tin vé -->
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID chuyến đi:</strong> <?php echo htmlspecialchars($id_trip); ?></p>
                <p><strong>Họ và tên:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Số ghế:</strong> <?php echo htmlspecialchars($number_seat); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Tổng giá trị:</strong> <?php echo htmlspecialchars($total_price); ?></p>
                <p><strong>Phương thức thanh toán:</strong> <?php echo $method == 1 ? 'Thẻ' : 'Tiền mặt'; ?></p>
                <p><strong>Ngày:</strong> <?php echo htmlspecialchars($date); ?></p>
                <p><strong>Xe:</strong> <?php echo htmlspecialchars($car_name); ?></p>
                <p><strong>Nhà xe:</strong> <?php echo htmlspecialchars($car_house_name); ?></p>
                <p><strong>Điểm đón:</strong> <?php echo htmlspecialchars($pickup_location); ?></p>
                <p><strong>Điểm trả:</strong> <?php echo htmlspecialchars($dropoff_location); ?></p>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
