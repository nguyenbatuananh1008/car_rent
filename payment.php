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
    $car_name = $_POST['car_name'] ?? null;
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
            <input type="hidden" name="id_trip" value="<?= $id_trip ?>">
    <input type="hidden" name="total_price" value="<?= $total_price ?>">
    <input type="hidden" name="user_id" value="<?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null ?>">
    <input type="hidden" name="name" value="<?= $name ?>" required>
    <input type="hidden" name="phone" value="<?= $phone ?>" required>
    <input type="hidden" name="email" value="<?= $email ?>" required>
    <input type="hidden" name="ticket_quantity" value="<?= $ticket_quantity ?>" required><br>

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
                    <h4 class="text-primary"><?= number_format($total_price, 0) ?> đ</h4>
                </div>

                <!-- Mã giảm giá -->
            

                <!-- Thông tin chuyến đi -->
                <div class="trip-info mb-4">
        <h5 class="mb-3">Thông tin chuyến đi</h5>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <p class="mb-0"><strong>Khởi hành : <?= htmlspecialchars($date) ?></strong></p>
            </div>
            <div>
                <a href="#" class="text-primary">Chi tiết</a>
            </div>
        </div>

        <!-- Thông tin xe -->
        <div class="d-flex align-items-center mb-3">
            <img src="" alt="Ninh Binh Car" class="me-3 rounded">
            <div>
                <h6 class="mb-1"> <?= htmlspecialchars($car_house_name) ?></h6>
                <p class="mb-1 text-muted"><?= htmlspecialchars($car_name) ?></p>
                <small><?= htmlspecialchars($ticket_quantity) ?> hành khách</small>
            </div>
        </div>

        <!-- Điểm khởi hành -->
        <div class="d-flex align-items-start mb-2">
            <div>
                <i class="bi bi-geo-alt-fill text-primary me-2"></i> <!-- Icon khởi hành -->
            </div>
            <div>
                <p class="mb-0"><strong><?= htmlspecialchars($pickup_time) ?></strong> - <?= htmlspecialchars($city_from_name) ?></p>
                <small class="text-muted"><?= htmlspecialchars($pickup_name) ?></small>
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
                <p class="mb-0"><strong><?= htmlspecialchars($dropoff_time) ?></strong> - <?= htmlspecialchars($city_to_name) ?></p>
                <small class="text-muted"><?= htmlspecialchars($dropoff_name) ?></small>
            </div>
            <div class="ms-auto">
                <a href="#" class="text-primary">Thay đổi</a>
            </div>
        </div>
    </div>



                <!-- Thông tin liên hệ -->
                <div class="trip-info">
                    <h5>Thông tin liên hệ</h5>
                    <p class="mb-1"><strong>Hành khách:</strong></strong> <?= htmlspecialchars($name) ?></p>
                    <p class="mb-1"><strong>Số điện thoại:</strong> <?= htmlspecialchars($phone) ?></p>
                    <p class="mb-1"><strong>Email:</strong><?= htmlspecialchars($email) ?></p>
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

