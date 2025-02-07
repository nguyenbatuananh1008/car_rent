<?php
require_once 'module/TripSearcher.php';

$city_from = $_GET['city_from'] ?? null;
$city_to = $_GET['city_to'] ?? null;
$date = $_GET['date'] ?? null;

if ($date) {
    // Chuyển đổi từ 'YYYY-MM-DD' sang 'DD-MM-YYYY'
    $date = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
} else {
    $date = null; // Xử lý trường hợp không có date
}

// Khởi tạo đối tượng TripSearcher
$tripSearcher = new TripSearcher();
$trips = [];

// Nếu đã có thông tin về điểm đi, điểm đến và ngày, thực hiện tìm kiếm chuyến xe
if ($city_from && $city_to && $date) {
    // Gọi hàm searchTrips để tìm kiếm chuyến xe
    $trips = $tripSearcher->searchTrips($city_from, $city_to, $date);

    // Nếu không tìm thấy chuyến, thông báo lỗi
    if (empty($trips)) {
        echo "Không có chuyến xe nào tìm thấy.";
    } else {
        // Tính toán số ghế còn lại và lọc chuyến xe
        $trips = array_filter(array_map(function ($trip) use ($tripSearcher, $date) {
            $number_seat = $tripSearcher->numberSeat($trip['id_trip'], $date);
            $remaining_seats = (int) $trip['remaining_seats'] - (int) $number_seat;
            $trip['remaining_seats'] = $remaining_seats;

            // Lấy danh sách điểm đón và trả
            $trip['pickup_locations'] = $tripSearcher->getLocations($trip['id_trip'], 0);
            $trip['dropoff_locations'] = $tripSearcher->getLocations($trip['id_trip'], 1);

            // Trả về chuyến xe sau khi xử lý
            return $trip;
        }, $trips), function ($trip) {
            // Chỉ giữ lại các chuyến có số ghế còn lại > 0
            return $trip['remaining_seats'] > 0;
        });
    }
}

include('layout/header.php');
?>

<style>
    .model_pg1i {
        overflow: hidden;
        height: 340px;
        transition: height 0.5s ease;
    }

    .expanded {
        height: 800px;
    }
</style>

<body>
    <div class="main_2 clearfix">
        <section id="center" class="center_o">
            <div class="center_om clearfix">
                <div class="container-xl">
                    <div class="row center_o1">
                        <div class="col-md-12">
                            <h2 class="text-white">Chuyến xe phổ biến</h2>
                            <h6 class="mb-0 mt-3 fw-normal col_oran">
                                <a class="text-light" href="index.php">Home</a>
                                <span class="mx-2 col_light">/</span> Chuyến xe
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include "layout/searchBar.php"; ?>

    <section id="model_pg" class="p_3">
        <div class="container-xl">
            <div class="row model_pg1">
                <?php if (!empty($trips)): ?>
                    <p class="text-success">Tìm thấy <strong><?= count($trips) ?></strong> chuyến xe phù hợp.</p>
                    <div class="row">
                        <?php foreach ($trips as $trip): ?>
                            <form id="booking-form" action="booking_info.php?date=<?= htmlspecialchars($date) ?>" method="POST">
                                <div class="col-md-9 shadow-lg p-3 mb-5 bg-white rounded ms-auto mb-4">
                                    <div class="model_pg1i clearfix">
                                        <div class="model_pg1i1">
                                            <div class="grid clearfix"></div>
                                        </div>
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
                                                <div class="col-md-9 col-sm-6">
                                                    <div class="model_pg1i2l">
                                                        <h4><?= htmlspecialchars($trip['car_house_name']) ?></h4>
                                                        <p><?= htmlspecialchars($trip['car_name']) ?> - <?= htmlspecialchars($trip['car_capacity']) ?> chỗ</p>
                                                        
    <?= isset($trip['full_route']) ? htmlspecialchars($trip['full_route']) : 'Không xác định' ?>
</p>

                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="model_pg1i2r text-end">
                                                        <h3 class="mb-1"><?= number_format($trip['price'], 0) ?> đ</h3>
                                                        <h6 class="mb-0 font_14">per day</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="model_pg1i3 row mt-4 mb-4">
                                                <div class="col-md-6 col-sm-6">
                                                <div class="model_pg1i3l ">
                                                        <h6><i class="fa-solid fa-clock col_oran me-1"></i><svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                    d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411" />
                                                            </svg><?= htmlspecialchars($trip['t_pick']) ?>-<?= htmlspecialchars($trip['city_from_name']) ?>
                                                        </h6>
                                                        <h6 class="mb-0 mt-3"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-geo-alt-fill"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                                            </svg><?= htmlspecialchars($trip['t_drop']) ?>
                                                            -<?= htmlspecialchars($trip['city_to_name']) ?>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="model_pg1i3l text-end">
                                                        <h6 class="mb-0"><i class="fa fa-female col_oran me-1"></i>Còn <?= htmlspecialchars($trip['remaining_seats']) ?> chỗ trống</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="model_pg1i4 row text-center mt-4">
                                            <p>*Vé chặng thuộc chuyến ngày <?= date("d/m/Y", strtotime($date))."".htmlspecialchars($trip['city_from_name'])."-".htmlspecialchars($trip['city_to_name'])   ?></p>
                                                   
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
                    <p>Không có chuyến xe nào phù hợp.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>

</html>

<?php include('layout/footer.php'); ?>
