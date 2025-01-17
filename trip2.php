<?php
require_once 'module/TripSearcher.php';

$city_from = $_GET['city_from'] ?? null;
$city_to = $_GET['city_to'] ?? null;
$date = $_GET['date'] ?? null;

$trips = [];

if ($city_from && $city_to && $date) {
    $tripSearcher = new TripSearcher();
    $trips = $tripSearcher->searchTrips($city_from, $city_to, $date);
}

include('layout/header.php');
?>

<div class="container mt-5">
    <h2>Kết quả tìm kiếm:</h2>
    <?php if (!empty($trips)): ?>
        <div class="row">
            <?php foreach ($trips as $trip): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="uploads/<?= htmlspecialchars($trip['car_image']) ?>" class="card-img-top" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($trip['car_house_name']) ?> - <?= htmlspecialchars($trip['car_name']) ?></h5>
                            <p class="card-text">
                                Điểm đi: <?= htmlspecialchars($trip['city_from_name']) ?><br>
                                Điểm đến: <?= htmlspecialchars($trip['city_to_name']) ?><br>
                                Số chỗ: <?= htmlspecialchars($trip['car_capacity']) ?><br>
                                Số chỗ còn lại: <?= htmlspecialchars($trip['remaining_seats']) ?><br>
                                Thời gian đi: <?= htmlspecialchars($trip['t_pick']) ?><br>
                                Thời gian đến: <?= htmlspecialchars($trip['t_drop']) ?><br>
                                Giá vé: <?= number_format($trip['price'], 0) ?> đ<br>
                                Ngày đi: <?= htmlspecialchars($trip['date']) ?>
                            </p>
                            <a href="#" class="btn btn-primary">Đặt vé</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Không tìm thấy chuyến xe nào phù hợp.</p>
    <?php endif; ?>
</div>

<?php include('layout/footer.php'); ?>
