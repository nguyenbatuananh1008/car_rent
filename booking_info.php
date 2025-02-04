    <?php
    require_once 'module/TripSearcher.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Lấy dữ liệu từ POST
    $id_trip = $_POST['id_trip'] ?? null;
    $pickup_location = $_POST['pickup_location'] ?? null;
    $dropoff_location = $_POST['dropoff_location'] ?? null;
    $time_location_pick = $_POST['location_time_pick'] ?? null;
    $time_location_drop = $_POST['location_time_drop'] ?? null;
    $ticket_quantity = $_POST['ticket_quantity'] ?? null;
    $date = $_GET['date'] ?? null;

    $car_house_name = $_POST['car_house_name'] ?? null;
    $city_from_name = $_POST['city_from_name'] ?? null;
    $city_to_name = $_POST['city_to_name'] ?? null;

    $pickup_data = $_POST['pickup_location'] ?? null;
    $dropoff_data = $_POST['dropoff_location'] ?? null;

    // Tách ID và thời gian từ value
    // Tách dữ liệu điểm đón
    list($pickup_id, $pickup_time, $pickup_name) = explode('|', $pickup_data);

    // Tách dữ liệu điểm trả
    list($dropoff_id, $dropoff_time, $dropoff_name) = explode('|', $dropoff_data);

    // Kiểm tra nếu thiếu dữ liệu đầu vào
    if (!$id_trip || !$pickup_location || !$dropoff_location || !$ticket_quantity) {
        die("Thiếu dữ liệu cần thiết để xử lý đặt vé.");
    }

    // Khởi tạo đối tượng TripSearcher
    $tripSearcher = new TripSearcher();

    // Lấy thông tin chuyến xe
    $trip_info = $tripSearcher->getTripById($id_trip);

    if (!$trip_info) {
        die("Không tìm thấy thông tin chuyến xe với ID: " . htmlspecialchars($id_trip));
    }

    // Xử lý thông tin vé khi người dùng xác nhận
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_booking'])) {
        $user_name = $_POST['name'] ?? null;
        $user_email = $_POST['email'] ?? null;
        $user_phone = $_POST['phone'] ?? null;
      

        // Kiểm tra dữ liệu người dùng nhập vào
        if (!$user_name || !$user_email || !$user_phone ) {
            echo "<p style='color:red;'>Vui lòng điền đầy đủ thông tin cá nhân và chọn phương thức thanh toán.</p>";
        } else {
            // Xác định giá trị của phương thức thanh toán
           
            $date = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            // Thêm thông tin vào bảng `ticket`
            $result = $tripSearcher->createTicket([
                'id_trip' => $id_trip,
                'id_user' => $id_user, // Nếu không có đăng nhập, để null
                'name' => $user_name,
                'phone' => $user_phone,
                'email' => $user_email,
                'number_seat' => $ticket_quantity, // Số lượng ghế
                'total_price' => $ticket_quantity * $trip_info['price'], // Tổng tiền
                'status' => '0', // Trạng thái ban đầu
                'method' =>'1', 
                'date' => $date, // Ngày khởi hành  
            ]);

            if ($result) {
                echo "<p style='color:green;'>Đặt vé thành công!</p>";
                // Chuyển hướng hoặc xử lý sau khi đặt vé thành công
            } else {
                echo "<p style='color:red;'>Đặt vé thất bại, vui lòng thử lại.</p>";
            }
        }
    }
    ?>

    <?php 
    include('layout/header.php');
    
    ?>
    <body>

    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="container mt-4">
            <a href="trip.php" class="text-decoration-none text-primary mb-3 d-block">&larr; Quay lại</a>

            <!-- Main Content -->
            <div class="row">
                <!-- Thông tin liên hệ -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Thông tin liên hệ</h5>
                            <form method="POST" action="payment.php">
                            <input type="hidden" name="id_trip" value="<?= htmlspecialchars($id_trip) ?>">
    <input type="hidden" name="pickup_location" value="<?= htmlspecialchars($pickup_location) ?>">
    <input type="hidden" name="dropoff_location" value="<?= htmlspecialchars($dropoff_location) ?>">
    <input type="hidden" name="ticket_quantity" value="<?= htmlspecialchars($ticket_quantity) ?>">
    <input type="hidden" name="car_house_name" value="<?= htmlspecialchars($car_house_name) ?>">
    <input type="hidden" name="city_from_name" value="<?= htmlspecialchars($city_from_name) ?>">
    <input type="hidden" name="city_to_name" value="<?= htmlspecialchars($city_to_name) ?>">
    <input type="hidden" name="pickup_time" value="<?= htmlspecialchars($pickup_time) ?>">
    <input type="hidden" name="pickup_name" value="<?= htmlspecialchars($pickup_name) ?>">
    <input type="hidden" name="dropoff_time" value="<?= htmlspecialchars($dropoff_time) ?>">
    <input type="hidden" name="dropoff_name" value="<?= htmlspecialchars($dropoff_name) ?>">
    <input type="hidden" name="trip_price" value="<?= htmlspecialchars($trip_info['price']) ?>">
    <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>"> 
    <input type="hidden" name="car_name" value="<?= htmlspecialchars($trip_info['car_name']) ?>">
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
                                    <label for="email" class="form-label">Email để nhận thông tin đặt chỗ <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Nhập email" required>
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
                            <h5 class="text-primary"> <?= number_format($trip_info['price'] * $ticket_quantity, 0) ?>đ</h5>
                            <hr>
                            <h5>Thông tin chuyến đi</h5>
                            <div class="summary-box bg-light mt-3">
                                <div class="details">
                                    <strong>Ngày khởi hành : <?= htmlspecialchars($date) ?></strong>
                                    <br>
                                    <strong><?= htmlspecialchars($car_house_name) ?></strong>
                                    <br>
                                    <?= htmlspecialchars($trip_info['car_name']) ?>
                                    <br>
                                    <small>Số khách: <?= htmlspecialchars($ticket_quantity) ?></small>
                                </div>
                                <hr>
                                <div class="details">
                                    <strong><?= htmlspecialchars($city_from_name) ?></strong>
                                    <br>
                                    <small><?= htmlspecialchars($pickup_time) ?> - <?= htmlspecialchars($pickup_name) ?></small>
                                </div>
                                <hr>
                                <div class="details">
                                    <strong><?= htmlspecialchars($city_to_name) ?></strong>
                                    <br>
                                    <small><?= htmlspecialchars($dropoff_time) ?>  - <?= htmlspecialchars($dropoff_name) ?></small>
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
