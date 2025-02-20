<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ticket-info-table th {
            width: 25%;
        }
        .ticket-info-table td {
            font-size: 16px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-image {
            width: 100%;
            max-width: 300px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Tiêu đề thông tin vé -->
        <div class="ticket-header">
            <h2 class="mb-4">Thông tin vé</h2>
            <img src="path/to/car_image.jpg" alt="Ảnh xe" class="ticket-image mb-3">
        </div>

        <!-- Hiển thị thông tin vé -->
        <table class="table table-bordered ticket-info-table">
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
                <td><?php echo htmlspecialchars($total_price); ?> VNĐ</td>
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
                <th>Xe</th>
                <td><?php echo htmlspecialchars($car_name); ?></td>
            </tr>
            <tr>
                <th>Nhà xe</th>
                <td><?php echo htmlspecialchars($car_house_name); ?></td>
            </tr>
            <tr>
                <th>Điểm đón</th>
                <td><?php echo htmlspecialchars($id_location_from); ?></td>
            </tr>
            <tr>
                <th>Điểm trả</th>
                <td><?php echo htmlspecialchars($id_location_to); ?></td>
            </tr>
            <tr>
                <th>Giờ đón</th>
                <td><?php echo htmlspecialchars($pickup_time); ?></td> <!-- Giả sử $pickup_time chứa giờ đón -->
            </tr>
        </table>

        <!-- Button để chụp lại thông tin -->
        <div class="text-center">
            <button class="btn btn-success" onclick="window.print();">Chụp lại thông tin vé</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
