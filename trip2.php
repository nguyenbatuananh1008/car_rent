

<?php 
include "layout/header.php";
?>
  
    <style>
        .payment-option {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        .payment-option:hover {
            background-color: #f9f9f9;
        }
        .trip-info, .discount-info {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
        }
        
     
    .btn-pay {
        background-color: #FF4D30; /* Màu cam */
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        padding: 15px 20px;
        font-size: 18px; /* Kích thước chữ lớn hơn */
        width: 100%; /* Nút rộng toàn bộ */
    }
    .btn-pay:hover {
        background-color:rgb(209, 103, 87); /* Màu cam đậm hơn khi hover */
    }
</style>

</head>

<body>
<div class="container my-4">
    <div class="row">
        <!-- Cột trái: Phương thức thanh toán -->
        <div class="col-lg-8">
            <h4>Phương thức thanh toán</h4>
            <!-- QR Chuyển khoản -->
            <div class="payment-option">
                <input type="radio" name="payment_method" id="qr_payment" class="form-check-input me-2">
                <label for="qr_payment" class="form-check-label"><strong>QR chuyển khoản/ Ví điện tử</strong></label>
                <p>Không cần nhập thông tin. Xác nhận thanh toán tức thì, nhanh chóng và ít sai sót.</p>
                <div class="mt-2">
                    <span class="badge bg-success">An toàn & Tiện lợi</span>
                    <img src="https://via.placeholder.com/100x20" alt="Các ví điện tử" class="ms-3">
                </div>
            </div>

            <!-- Thẻ thanh toán quốc tế -->
            <div class="payment-option">
                <input type="radio" name="payment_method" id="card_payment" class="form-check-input me-2">
                <label for="card_payment" class="form-check-label"><strong>Thẻ thanh toán quốc tế</strong></label>
                <p>Thẻ Visa, MasterCard, JCB</p>
                <ul class="text-success">
                    <li>Nhập mã VEXEREHDS50 và VEXEREHDS100 tại Vexere - Giảm 50K và 100K.</li>
                    <li>Nhập mã VEXERENAMA tại Vexere - Giảm 20% tối đa 60K.</li>
                </ul>
                <a href="#" class="text-primary">Điều kiện sử dụng</a>
            </div>

            <!-- Ví ShopeePay -->
            <div class="payment-option">
                <input type="radio" name="payment_method" id="shopeepay" class="form-check-input me-2">
                <label for="shopeepay" class="form-check-label"><strong>Ví ShopeePay</strong></label>
                <p>Giảm 10K khi thanh toán đơn hàng từ 50K.</p>
                <a href="#" class="text-primary">Điều kiện sử dụng</a>
            </div>

            <!-- Ví ZaloPay -->
            <div class="payment-option">
                <input type="radio" name="payment_method" id="zalopay" class="form-check-input me-2">
                <label for="zalopay" class="form-check-label"><strong>Ví ZaloPay</strong></label>
                <p>Giảm 15K hoặc 35K khi nhập mã ZLPVXR.</p>
                <a href="#" class="text-primary">Điều kiện sử dụng</a>
            </div>

            <!-- Thanh toán VNPay -->
            <div class="payment-option">
                <input type="radio" name="payment_method" id="vnpay" class="form-check-input me-2">
                <label for="vnpay" class="form-check-label"><strong>Thanh toán VNPAY - QR</strong></label>
                <p>Giảm 15K và 35K khi nhập mã VNPAVXR12.</p>
                <a href="#" class="text-primary">Điều kiện sử dụng</a>
            </div>
        </div>

        <!-- Cột phải: Tổng tiền và thông tin chuyến đi -->
        <div class="col-lg-4">
            <!-- Tổng tiền -->
            <div class="trip-info mb-4">
                <h5 class="mb-2">Tổng tiền</h5>
                <h4 class="text-primary">170.000đ</h4>
            </div>

            <!-- Mã giảm giá -->
           

            <!-- Thông tin chuyến đi -->
            <div class="trip-info mb-4">
    <h5 class="mb-3">Thông tin chuyến đi</h5>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <p class="mb-0"><strong>T4, 22/01/2025</strong></p>
        </div>
        <div>
            <a href="#" class="text-primary">Chi tiết</a>
        </div>
    </div>

    <!-- Thông tin xe -->
    <div class="d-flex align-items-center mb-3">
        <img src="https://via.placeholder.com/80x50" alt="Ninh Binh Car" class="me-3 rounded">
        <div>
            <h6 class="mb-1">Ninh Binh Car</h6>
            <p class="mb-1 text-muted">Limousine 12 chỗ</p>
            <small>1 hành khách</small>
        </div>
    </div>

    <!-- Điểm khởi hành -->
    <div class="d-flex align-items-start mb-2">
        <div>
            <i class="bi bi-geo-alt-fill text-primary me-2"></i> <!-- Icon khởi hành -->
        </div>
        <div>
            <p class="mb-0"><strong>19:00</strong> - Văn phòng Hà Nội</p>
            <small class="text-muted">Số 21, ngõ 42/94/8 phố Thịnh Liệt</small>
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
            <p class="mb-0"><strong>20:30</strong> - Yên Quang (Nam Định)</p>
            <small class="text-muted">Đồng Duy, Ý Yên</small>
        </div>
        <div class="ms-auto">
            <a href="#" class="text-primary">Thay đổi</a>
        </div>
    </div>
</div>


            <!-- Thông tin liên hệ -->
            <div class="trip-info">
                <h5>Thông tin liên hệ</h5>
                <p class="mb-1"><strong>Hành khách:</strong> Nguyễn Bá Tuấn Anh</p>
                <p class="mb-1"><strong>Số điện thoại:</strong> 0343488423</p>
                <p class="mb-1"><strong>Email:</strong> tuananhnguyenba1008@gmail.com</p>
                <a href="#" class="text-primary">Chỉnh sửa</a>
            </div>
        </div>
    </div>

    <!-- Nút thanh toán -->
    <div class="text-center mt-4">
    <button class="btn btn-pay">Thanh toán</button>
    <p class="mt-2 text-muted">Bạn sẽ sớm nhận được biến số xe, số điện thoại tài xế và dễ dàng thay đổi điểm đón trả sau khi đặt.</p>
</div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
