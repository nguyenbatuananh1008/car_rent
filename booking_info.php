<?php
require_once 'module/TripSearcher.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu người dùng đã đăng nhập
$id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


// Lấy dữ liệu từ POST
$id_trip = $_POST['id_trip'] ?? null;
$pickup_location = $_POST['pickup_location'] ?? null;
$dropoff_location = $_POST['dropoff_location'] ?? null;
$ticket_quantity = $_POST['ticket_quantity'] ?? null;
$date = $_GET['date'] ?? null;
$pickup_location_name = $_POST["pickup_name_{$pickup_location}"] ?? 'Không xác định';
$dropoff_location_name = $_POST["dropoff_name_{$dropoff_location}"] ?? 'Không xác định';


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
    if (!$user_name || !$user_email || !$user_phone) {
        echo "<p style='color:red;'>Vui lòng điền đầy đủ thông tin cá nhân.</p>";
    } else {
        // Thêm thông tin vào bảng `ticket`
            $result = $tripSearcher->createTicket([
                'id_trip' => $id_trip,
                'id_user' =>$id_user , // Nếu không có đăng nhập, để null
                'name' => $user_name,
                'phone' => $user_phone,
                'email' => $user_email,
                'number_seat' => $ticket_quantity, // Số lượng ghế
                'total_price' => $ticket_quantity * $trip_info['price'], // Tổng tiền
                'status' => 'Pending', // Trạng thái ban đầu
                'method' => 'Cash', // Hoặc phương thức thanh toán khác (nếu có)
                'date' => $date, // Ngày đặt vé
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
        
    <div class="container mt-4">
        <a href="#" class="text-decoration-none text-primary mb-3 d-block">&larr; Quay lại</a>

        <!-- Main Content -->
        <div class="row">
            <!-- Thông tin liên hệ -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <button class="btn btn-login mb-3 float-end">Đăng nhập</button>
                        <h5>Thông tin liên hệ</h5>
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên người đi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" placeholder="Nhập tên">
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-2">
                                    <label for="phone-prefix" class="form-label">VN</label>
                                    <input type="text" class="form-control" id="phone-prefix" value="+84" readonly>
                                </div>
                                <div class="col-md-10">
                                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email để nhận thông tin đặt chỗ <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="Nhập email">
                                <div class="form-text text-success mt-2">
                                    Số điện thoại và email được sử dụng để gửi thông tin đơn hàng và liên hệ khi cần
                                    thiết.
                                </div>
                            </div>
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
                        <h5 class="text-primary">170.000đ</h5>
                        <hr>
                        <h5>Thông tin chuyến đi</h5>
                        <div class="summary-box bg-light mt-3">
                            <div class="details">
                                <strong>CN, 19/01/2025</strong>
                                <br>
                                <strong>Ninh Bình Car</strong>
                                <br>
                                Limousine 12 chỗ
                                <br>
                                <small>Số khách: 1</small>
                            </div>
                            <hr>
                            <div class="details">
                                <strong>Văn phòng Hà Nội</strong>
                                <br>
                                <small>19:00 - Số 21, ngõ 42/94/8 phố Thịnh Liệt, Hoàng Mai, Hà Nội</small>
                                <a href="#" class="text-primary float-end">Thay đổi</a>
                            </div>
                            <hr>
                            <div class="details">
                                <strong>Nam Định (Ý Yên)</strong>
                                <br>
                                <small>19:50 - QL38B, Văn Điển, Thị trấn Lâm, Ý Yên, Nam Định</small>
                                <a href="#" class="text-primary float-end">Thay đổi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


























<!-- Hiển thị thông tin chuyến -->
<h2>Xác nhận thông tin vé</h2>
<p><strong>Tên xe:</strong> <?= htmlspecialchars($trip_info['car_name']) ?></p>
<p><strong>Điểm đón:</strong> <?= htmlspecialchars($pickup_location_name) ?></p>
<p><strong>Điểm trả:</strong> <?= htmlspecialchars($dropoff_location_name) ?></p>
<p><strong>Số lượng vé:</strong> <?= htmlspecialchars($ticket_quantity) ?></p>
<p><strong>Ngày khởi hành :</strong> <?= htmlspecialchars($date) ?></p>
<p><strong>Giá vé:</strong> <?= number_format($trip_info['price'] * $ticket_quantity, 0) ?> VND</p>

<!-- Form nhập thông tin cá nhân -->
<form method="POST">
    <input type="hidden" name="id_trip" value="<?= htmlspecialchars($id_trip) ?>">
    <input type="hidden" name="pickup_location" value="<?= htmlspecialchars($pickup_location) ?>">
    <input type="hidden" name="dropoff_location" value="<?= htmlspecialchars($dropoff_location) ?>">
    <input type="hidden" name="ticket_quantity" value="<?= htmlspecialchars($ticket_quantity) ?>">

    <label for="name">Tên:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="phone">Số điện thoại:</label>
    <input type="text" id="phone" name="phone" required>
    <br>
    <button type="submit" name="confirm_booking">Đặt vé</button>
</form>
    