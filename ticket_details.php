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
$car_capacity= $ticket_info['car_capacity'];
$car_type = $ticket_info['car_type'];
$car_image = $ticket_info['car_image'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Thông tin vé</h2>
        <table class="table table-bordered">
            <tr>
                <th>ID chuyến đi</th>
                <td><?php echo htmlspecialchars($id_trip); ?></td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td><?php echo htmlspecialchars($name); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?php echo htmlspecialchars($phone); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>Số ghế</th>
                <td><?php echo htmlspecialchars($number_seat); ?></td>
            </tr>
            <tr>
                <th>Tổng giá trị</th>
                <td><?php echo htmlspecialchars($total_price); ?></td>
            </tr>
            <tr>
                <th>Phương thức thanh toán</th>
                <td><?php echo $method == 1 ? 'Thẻ' : 'Tiền mặt'; ?></td>
            </tr>
            <tr>
                <th>Ngày</th>
                <td><?php echo htmlspecialchars($date); ?></td>
            </tr>
            <tr>
                <th>xe</th>
                <td><?php echo htmlspecialchars($car_name); ?></td>
            </tr>
            <tr>
                <th>Nhà xe</th>
                <td><?php echo htmlspecialchars($car_house_name ); ?></td>
            </tr>
        </table>

        <!-- Button để chụp lại thông tin -->
        <button class="btn btn-success" onclick="window.print();">Chụp lại thông tin vé</button>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
