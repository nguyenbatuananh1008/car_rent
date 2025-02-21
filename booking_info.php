<?php
$date = $_GET['date'] ?? '';
// Định dạng lại ngày thành "T2, ngày x tháng y năm z"
$dayOfWeek = date('l', strtotime($date)); // Lấy tên thứ bằng tiếng Anh
$daysInVietnameseShort = [
    'Sunday' => 'CN',
    'Monday' => 'T2',
    'Tuesday' => 'T3',
    'Wednesday' => 'T4',
    'Thursday' => 'T5',
    'Friday' => 'T6',
    'Saturday' => 'T7'
];
$formattedDate = $daysInVietnameseShort[$dayOfWeek] . ', ' . date('d', strtotime($date)) . '/' . date('m', strtotime($date)) . '/' . date('Y', strtotime($date));
//
$id_trip         = $_POST['id_trip'] ?? '';
$route_id        = $_POST['route_id'] ?? '';
$car_house_name  = $_POST['car_house_name'] ?? '';
$car_name        = $_POST['car_name'] ?? 'Thông tin xe không có';
$full_route      = $_POST['full_route'] ?? 'Không xác định';

$pick_city       =$_POST['pick_city'] ?? '';
$city_from       = $_POST['city_from'] ?? '';
$city_to         = $_POST['city_to'] ?? '';
$city_from_name  = $_POST['city_from_name'] ?? '';
$city_to_name    = $_POST['city_to_name'] ?? '';
$car_capacity    = $_POST['car_capacity'] ?? '';
$num_seats_field = "num_seats_" . $route_id;
$num_seats       = $_POST[$num_seats_field] ?? 1;
$carImage = $_POST['car_image'] ?? '';
$car_type = $_POST['car_type'] ?? '';
$car_color = $_POST['car_color'] ?? '';

//
$pickupData = $_POST["pickup_$route_id"] ?? '';
$dropoffData = $_POST["dropoff_$route_id"] ?? '';

$pickupLocation = $pickupCity = $dropoffLocation = $dropoffCity = $pickupTime =$dropoffTime = $id_location_from= $id_location_to = '';

if ($pickupData) {
    // Tách giá trị dựa trên dấu "||"
    list($pickupLocation, $pickupCity, $pickupTime,$id_location_from) = explode('||', $pickupData);
}


if ($dropoffData) {
    list($dropoffLocation, $dropoffCity, $dropoffTime,$id_location_to) = explode('||', $dropoffData);
}




// Giá vé: Bạn có thể gửi thêm một trường hidden "price" hoặc tự tính lại dựa trên dữ liệu từ CSDL
$total_price  = $_POST['total_price'] ?? 0;  // Ví dụ, nếu bạn gửi trường hidden giá vé của chuyến xe

?>

    <?php 
    include('layout/header.php');
    
    ?>
    <body>

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="container mt-4">
            <a href="trip_results.php" class="text-decoration-none text-primary mb-3 d-block">&larr; Quay lại</a>

            <!-- Main Content -->
            <div class="row">
                <!-- Thông tin liên hệ -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Thông tin liên hệ</h5>
                            <form method="POST" action="payment.php">
                                <!-- Các thông tin chuyến xe được gửi qua POST -->
<input type="hidden" name="id_trip" value="<?= htmlspecialchars($id_trip) ?>">
<input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
<input type="hidden" name="formatted_date" value="<?= htmlspecialchars($formattedDate) ?>">
<input type="hidden" name="trip_id" value="<?= htmlspecialchars($trip_id) ?>">
<input type="hidden" name="route_id" value="<?= htmlspecialchars($route_id) ?>">
<input type="hidden" name="car_house_name" value="<?= htmlspecialchars($car_house_name) ?>">
<input type="hidden" name="car_name" value="<?= htmlspecialchars($car_name) ?>">
<input type="hidden" name="car_capacity" value="<?= htmlspecialchars($car_capacity) ?>">
<input type="hidden" name="num_seats" value="<?= htmlspecialchars($num_seats) ?>">
<input type="hidden" name="car_image" value="<?= htmlspecialchars($carImage) ?>">
<input type="hidden" name="car_type" value="<?= htmlspecialchars($car_type) ?>">
<input type="hidden" name="car_color" value="<?= htmlspecialchars($car_color) ?>">
<input type="hidden" name="pickup_location" value="<?= htmlspecialchars($pickupLocation) ?>">
<input type="hidden" name="pickup_city" value="<?= htmlspecialchars($pickupCity) ?>">
<input type="hidden" name="pickup_time" value="<?= htmlspecialchars($pickupTime) ?>">
<input type="hidden" name="dropoff_location" value="<?= htmlspecialchars($dropoffLocation) ?>">
<input type="hidden" name="dropoff_city" value="<?= htmlspecialchars($dropoffCity) ?>">
<input type="hidden" name="dropoff_time" value="<?= htmlspecialchars($dropoffTime) ?>">
<input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">
<input type="hidden" name="id_location_from" value="<?= htmlspecialchars($id_location_from) ?>">
<input type="hidden" name="id_location_to" value="<?= htmlspecialchars($id_location_to) ?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên người đi <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Nhập tên" required>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-2">
                                        <label for="phone-prefix" class="form-label">VN</label>
                                        <input type="text" class="form-control" id="phone-prefix" value="+84" readonly>
                                    </div>
                                    <div class="col-md-10">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Nhập email( nếu có )</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email">
                                </div>
                                
                                <button class="btn btn-primary" name="confirm_booking" type="submit">Tiếp tục</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Thông tin chuyến đi -->
                <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Tạm tính</h5>
            </div>
            <div class="card-body">
                <h5 class="text-primary"><?= number_format($total_price) ?>đ</h5>
                <hr>
                <div>
                <strong>Khởi hành: <?= htmlspecialchars($formattedDate) ?></strong>
            </div>
                <h5>Thông tin chuyến đi</h5>
                <div class="summary-box bg-light mt-3">
                    <div class="details d-flex align-items-center">
                        <img src="admin/uploads/<?= htmlspecialchars($carImage) ?>" alt="Car Image" style="width:90px; height:60px; margin-right: 15px;">
                        <div>
                            <strong><?= htmlspecialchars($car_house_name) ?></strong><br>
                            <?= htmlspecialchars($car_name) ?>(<?= htmlspecialchars($car_color) ?>)-<?= htmlspecialchars($car_capacity) ?> chỗ<br>
                            <small>Số khách: <?= htmlspecialchars($num_seats) ?></small>
                        </div>
                    </div>
                    <hr>
                    <div class="details">
                        <strong><?= htmlspecialchars($pickupCity) ?></strong><br>
                        <small><?= htmlspecialchars($pickupTime) ?> - <?= htmlspecialchars($pickupLocation) ?></small>
                    </div>
                    <hr>
                    <div class="details">
                        <strong><?= htmlspecialchars($dropoffCity) ?></strong><br>
                        <small><?= htmlspecialchars($dropoffTime) ?> - <?= htmlspecialchars($dropoffLocation) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
            </div>
        </div>
    </div>

    </body>
    </html>
