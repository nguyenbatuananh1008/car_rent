    <?php
$id_trip = $_POST['id_trip'];
  $date = $_POST['date'] ?? '';
  $formattedDate = $_POST['formatted_date'] ?? '';
  $trip_id = $_POST['trip_id'] ?? '';
  $route_id = $_POST['route_id'] ?? '';
  $car_house_name = $_POST['car_house_name'] ?? '';
  $car_name = $_POST['car_name'] ?? '';
  $car_capacity = $_POST['car_capacity'] ?? '';
  $num_seats = $_POST['num_seats'] ?? '';
  $car_image = $_POST['car_image'] ?? '';
  $car_type = $_POST['car_type'] ?? '';
  $car_color = $_POST['car_color'] ?? '';
  $pickup_location = $_POST['pickup_location'] ?? '';
  $pickup_city = $_POST['pickup_city'] ?? '';
  $pickup_time = $_POST['pickup_time'] ?? '';
  $dropoff_location = $_POST['dropoff_location'] ?? '';
  $dropoff_city = $_POST['dropoff_city'] ?? '';
  $dropoff_time = $_POST['dropoff_time'] ?? '';
  $total_price = $_POST['total_price'] ?? 0;
  $id_location_from = $_POST['id_location_from'] ?? '';
  $id_location_to = $_POST['id_location_to'] ?? '';
  $name = $_POST['name'] ?? null;
  $phone = $_POST['phone'] ?? '';
  $email = $_POST['email'] ?? null;

    ?>




    <head>
    <?php 
    include "layout/header.php";
    ?>
        <link rel="stylesheet" href="css/pay.css">
    </head>
    <style>
        .img-fluid {
            width: 100px; /* Đặt chiều rộng cố định cho ảnh QR */
            height: auto; /* Tự động điều chỉnh chiều cao theo tỷ lệ */
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 8px;
        }
        
    </style>
    

    <body>
    <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="container content-container">
        <div class="row">
            <!-- Cột trái: Phương thức thanh toán -->
            <div class="col-lg-8">
            <form action="module/process_payment.php" method="POST">

                <h4>Phương thức thanh toán</h4>
                <!-- QR Chuyển khoản -->
                <div class="payment-option mt-5">
                    <input type="radio" name="method" id="qr_payment" class="form-check-input me-2" value="2" required>
                    <label for="qr_payment" class="form-check-label"><strong>QR chuyển khoản/ Ví điện tử</strong></label>
                    <p>Không cần nhập thông tin. Xác nhận thanh toán tức thì, nhanh chóng và ít sai sót.</p>
                    <div class="mt-2">
                        <span class="badge bg-success">An toàn & Tiện lợi</span>
                        <img src="https://via.placeholder.com/100x20" alt="Các ví điện tử" class="ms-3">
                    </div>  
                    <div id="qr-container">
                        
                    </div>

                </div>

                <!-- Thẻ thanh toán quốc tế -->
                <div class="payment-option">
                    <input type="radio" name="method" id="card_payment" class="form-check-input me-2"value="1" required>
                    <label for="card_payment" class="form-check-label"><strong>Thẻ thanh toán quốc tế</strong></label>
                    <p>Thẻ Visa, MasterCard, JCB</p>
                    <ul class="text-success">
                        <li>Nhập mã VEXEREHDS50 và VEXEREHDS100 tại Vexere - Giảm 50K và 100K.</li>
                        <li>Nhập mã VEXERENAMA tại Vexere - Giảm 20% tối đa 60K.</li>
                    </ul>
                    <a href="#" class="text-primary">Điều kiện sử dụng</a>
                </div>
                <!-- thanh toán tại xe  -->
                 <div class="payment-option">
                <input type="radio" name="method" id="cash_payment" class="form-check-input me-2" value="0" required>
                <label for="cash_payment" class="form-check-label"><strong>Thanh toán tại xe</strong></label>
            </div>

                
            
            
            </div>

            <!-- Cột phải: Tổng tiền và thông tin chuyến đi -->
            <div class="col-lg-4">
                <!-- Tổng tiền -->
                <div class="trip-info mb-4">
                    <h5 class="mb-2">Tổng tiền</h5>
                    <h4 class="text-primary"><?= number_format(  $total_price) ?> đ</h4>
                </div>

                <!-- Mã giảm giá -->
            

                <!-- Thông tin chuyến đi -->
                <input type="hidden" name="id_trip" value="<?= htmlspecialchars($id_trip) ?>">
    <input type="hidden" name="id_user" value="<?= htmlspecialchars($id_user) ?>">
    <input type="hidden" name="name" value="<?= htmlspecialchars($_POST['name'])?>">
    <input type="hidden" name="email" value="<?= htmlspecialchars($_POST['email'])?>">
    <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
    <input type="hidden" name="number_seat" value="<?= htmlspecialchars($num_seats) ?>">
    <input type="hidden" name="total_price" value="<?= htmlspecialchars($total_price) ?>">
    <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
    <input type="hidden" name="id_location_from" value="<?= htmlspecialchars($id_location_from) ?>">
    <input type="hidden" name="id_location_to" value="<?= htmlspecialchars($id_location_to) ?>">
    <input type="hidden" name="car_name" value="<?= htmlspecialchars($car_name) ?>">
    <input type="hidden" name="car_house_name" value="<?= htmlspecialchars($car_house_name) ?>">
    <input type="hidden" name="car_image" value="<?= htmlspecialchars($car_image) ?>">
    <input type="hidden" name="car_capacity" value="<?= htmlspecialchars($car_capacity) ?>">
    <input type="hidden" name="car_color" value="<?= htmlspecialchars($car_color) ?>">
    <input type="hidden" name="car_type" value="<?= htmlspecialchars($car_type) ?>">
    <input type="hidden" name="pickup_location" value="<?= htmlspecialchars($pickup_location) ?>">
    <input type="hidden" name="dropoff_location" value="<?= htmlspecialchars($dropoff_location) ?>">
    <input type="hidden" name="pickup_time" value="<?= htmlspecialchars($pickup_time) ?>">
                <div class="trip-info mb-4">
        <h5 class="mb-3">Thông tin chuyến đi</h5>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="mb-0"><strong>Khởi hành : <?= htmlspecialchars( $formattedDate ) ?></strong></p>
            </div>
        
        </div>

        <!-- Thông tin xe -->
        <div class="d-flex align-items-center mb-3">
        <img src="admin/uploads/<?= htmlspecialchars( $car_image) ?>" alt="Car Image" style="width:90px; height:60px; margin-right: 15px;">
            <div>
            
                <h5 class="mb-1"><?= htmlspecialchars(  $car_house_name) ?></h5>
                <p class="mb-1 text-muted"><?= htmlspecialchars($car_name) ?>(<?= htmlspecialchars($car_color) ?>)</p>
                <small><?= htmlspecialchars(  $num_seats) ?> hành khách</small>
            </div>
        </div>

        <!-- Điểm khởi hành -->
        <div class="d-flex align-items-start mb-2">
            <div>
                <i class="bi bi-geo-alt-fill text-primary me-2"></i> <!-- Icon khởi hành -->
            </div>
            <div>
                <strong><h5><?= htmlspecialchars($pickup_city) ?></h5></strong>
                <p class="mb-0"><strong><?= htmlspecialchars($pickup_time) ?></strong> - <?= htmlspecialchars($pickup_location) ?></p>
                
            </div>
            <div class="ms-auto">
                <a href="#" class="text-primary">Thay đổi</a>
            </div>
        </div>

        <!-- Điểm đến -->
        <div class="d-flex align-items-start">
            <div>
                <i class="bi bi-pin-map-fill text-danger me-2"></i> <!-- Icon điểm đến -->
            </div>
            <div>
            <strong><h5><?= htmlspecialchars($dropoff_city) ?></h5></strong>
                <p class="mb-0"><strong><?= htmlspecialchars($dropoff_time) ?></strong> - <?= htmlspecialchars($dropoff_location ) ?></p>
                
            </div>
            <div class="ms-auto">
                <a href="#" class="text-primary">Thay đổi</a>
            </div>
        </div>
    </div>



                <!-- Thông tin liên hệ -->
                <div class="trip-info">
                    <h5>Thông tin liên hệ</h5>
                    <p class="mb-1"><strong>Hành khách:</strong><?= htmlspecialchars($_POST['name']) ?></p>
                    <p class="mb-1"><strong>Số điện thoại:</strong> <?= htmlspecialchars($phone) ?></p>
                    <p class="mb-1"><strong>Email:</strong><?= htmlspecialchars($_POST['email'])?></p>
                    <a href="#" class="text-primary">Chỉnh sửa</a>
                </div>
            </div>
        </div>

        <!-- Nút thanh toán -->
        <div class="text-center mt-4">
        <button type="submit" class="btn btn-pay">Thanh toán</button>
        </form>
        <p class="mt-2 text-muted">Bạn sẽ sớm nhận được biến số xe, số điện thoại tài xế và dễ dàng thay đổi điểm đón trả sau khi đặt.</p>
    </div>

    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <script>
    // Lấy các phần tử thanh toán
    const qrPaymentOption = document.getElementById('qr_payment');
    const cardPaymentOption = document.getElementById('card_payment');
    const qrContainer = document.getElementById('qr-container');

    // Khi chọn thanh toán QR
    qrPaymentOption.addEventListener('change', function () {
        if (this.checked) {
            const bankName = "MBBank"; // Tên ngân hàng
            const accountNumber = "0000542277521"; // Số tài khoản
            const amount = <?= $total_price ?>; // Lấy số tiền từ PHP
            const note = "Thanh toan ve xe"; // Nội dung thanh toán
            const fullName = "NGUYEN BA TUAN ANH"; // Tên người nhận
            const template = "compact"; // Loại template QR

            // Gửi yêu cầu POST tới generate_qr.php
            fetch('module/generate_qr.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `bankName=${bankName}&accountNumber=${accountNumber}&amount=${amount}&note=${encodeURIComponent(note)}&fullName=${encodeURIComponent(fullName)}&template=${template}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.qr_url) {
                    qrContainer.innerHTML = `
                        <div class="mt-4">
                            <h5>Vui lòng quét QR để thanh toán </h5>
                            <img src="${data.qr_url}" alt="QR Code" class="img-fluid">
                        </div>
                    `;
                    qrContainer.style.display = 'block'; // Hiển thị QR Container
                } else {
                    qrContainer.innerHTML = `<p class="text-danger">Không thể tạo mã QR. Vui lòng thử lại sau.</p>`;
                    qrContainer.style.display = 'block'; // Hiển thị lỗi
                }
            })
            .catch(error => {
                qrContainer.innerHTML = `<p class="text-danger">Lỗi xảy ra: ${error.message}</p>`;
                qrContainer.style.display = 'block'; // Hiển thị lỗi
            });
        }
    });

    // Khi chọn thanh toán quốc tế hoặc phương thức khác
    cardPaymentOption.addEventListener('change', function () {
        if (this.checked) {
            qrContainer.style.display = 'none'; // Ẩn QR Container
            qrContainer.innerHTAML = ''; // Xóa nội dung mã QR
        }
    });



    </script>

