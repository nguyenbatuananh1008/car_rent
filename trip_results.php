<?php
require_once 'module/db.php';
require_once 'module/TripSearcher.php';

// Nhận tham số từ GET
$city_from = isset($_GET['city_from']) ? $_GET['city_from'] : null;
$city_to = isset($_GET['city_to']) ? $_GET['city_to'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;

// Kiểm tra và chuyển đổi ngày (nếu có)
if ($date) {
    try {
        $date = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    } catch (Exception $e) {
        // Nếu không thể định dạng lại ngày, trả về thông báo lỗi
        echo "Ngày không hợp lệ.";
        exit;
    }
} else {
    $date = null;
}

// Khởi tạo đối tượng TripSearcher
$tripSearcher = new TripSearcher();
$trips = []; // Khởi tạo biến $trips

// Kiểm tra nếu có thông tin tìm kiếm hợp lệ
if ($city_from && $city_to && $date) {
    // Gọi hàm searchTrips để lấy dữ liệu chuyến xe
    $trips = $tripSearcher->searchTrips($city_from, $city_to, $date);

    // Kiểm tra nếu không có chuyến xe
    if (empty($trips)) {
        echo "Không tìm thấy chuyến xe.";
    }
} else {
    echo "Vui lòng nhập đầy đủ thông tin.";
    exit;
}

?>

<div class="container-xl shadow-lg p-3 mb-5 bg-white rounded">
    <div class="row">
        <h3>Kết quả tìm kiếm</h3>
        <?php if (!empty($trips)): ?>
            <p class="text-success">Tìm thấy <strong><?= count($trips) ?></strong> chuyến xe phù hợp.</p>

            <div class="row">
                <?php foreach ($trips as $trip): ?>
                    <form id="booking-form" action="booking_info.php?date=<?= htmlspecialchars($date) ?>" method="POST">
                        <div class="col-md-9 shadow-lg p-3 mb-5 bg-white rounded ms-auto mb-4">
                            <div class="model_pg1i clearfix">
                                <input type="hidden" name="car_house_name" value="<?= htmlspecialchars($trip['car_house_name']) ?>">
                                <input type="hidden" name="city_from" value="<?= htmlspecialchars($city_from) ?>">
                                <input type="hidden" name="city_to" value="<?= htmlspecialchars($city_to) ?>">
                                <input type="hidden" name="city_from_name" value="<?= htmlspecialchars($trip['city_from_name']) ?>">
                                <input type="hidden" name="city_to_name" value="<?= htmlspecialchars($trip['city_to_name']) ?>">
                                <div class="model_m p-3 clearfix border-top-0 text-center">
                                    <div class="float-start">
                                        <img src="admin/uploads/<?= htmlspecialchars($trip['car_image']) ?>"
                                             class="card-img-top" alt="Car Image" style="width: 200px; height: 100px;">
                                    </div>
                                    <div class="model_pg1i2 row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="model_pg1i2l">
                                                <h4><?= htmlspecialchars($trip['car_house_name']) ?></h4>
                                                <p><?= htmlspecialchars($trip['car_name']) ?> - <?= htmlspecialchars($trip['car_capacity']) ?> chỗ</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="model_pg1i2r text-end">
                                                <h3 class="mb-1"><?= number_format($trip['price'], 0) ?> đ</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="model_pg1i3 row mt-4 mb-4 ">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="model_pg1i3l">
                                                <h6><?= htmlspecialchars($trip['t_pick']) ?> - <?= htmlspecialchars($trip['city_from_name']) ?></h6>
                                                <h6><?= htmlspecialchars($trip['t_drop']) ?> - <?= htmlspecialchars($trip['city_to_name']) ?></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="model_pg1i3l text-end">
                                                <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i>Còn <?= htmlspecialchars($trip['remaining_seats']) ?> chỗ trống</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="model_pg1i4 row text-center mt-4">
                                        <p>*Vé chặng thuộc chuyến ngày <?= htmlspecialchars($date) ?></p>
                                        <div class="col-md-12">
                                            <h6 class="mb-0">
                                                <a class="buttonn button float-end" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Không tìm thấy chuyến xe nào phù hợp.</p>
        <?php endif; ?>
    </div>
</div>

<?php include('layout/footer.php'); ?>
