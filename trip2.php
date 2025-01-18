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


