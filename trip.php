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
$tripSearcher = new TripSearcher();
$trips = [];
$errors_location = [];
if ($city_from && $city_to && $date) {
    $trips = $tripSearcher->searchTrips($city_from, $city_to, $date);

    // Tính toán số ghế còn lại và lấy lộ trình cho mỗi chuyến
    $trips = array_map(function ($trip) use ($tripSearcher, $date) {
        $number_seat = $tripSearcher->numberSeat($trip['id_trip'], $date);
        $remaining_seats = (int)$trip['remaining_seats'] - (int)$number_seat;
        $trip['remaining_seats'] = $remaining_seats;

        // Lấy danh sách điểm đón và trả
        $trip['pickup_locations'] = $tripSearcher->getLocations($trip['id_trip'], 0);
        $trip['dropoff_locations'] = $tripSearcher->getLocations($trip['id_trip'], 1);
        
        if (empty($trip['pickup_locations']) || empty($trip['dropoff_locations'])) {
            $errors_location ="Chuyến xe chưa có lộ trình ";
        }
        

        return $trip;
    }, $trips);
}

include('layout/header.php');


?>
<style>
    .model_pg1i {
        overflow: hidden;
        height: 340px; /* Chiều cao mặc định */
        transition: height 0.5s ease; /* Hiệu ứng mượt mà khi thay đổi chiều cao */
    }

    .expanded {
        height: 800px; /* Chiều cao mở rộng */
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
                            <h6 class="mb-0 mt-3 fw-normal col_oran"><a class="text-light" href="index.php">Home</a>
                                <span class="mx-2 col_light">/</span> Chuyến xe</h6>
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
                            <div class="col-md-9 shadow-lg p-3 mb-5 bg-white rounded ms-auto mb-4"> <!-- Thêm class mb-4 -->
                                <div class="model_pg1i clearfix">
                                    <div class="model_pg1i1">
                                        <div class="grid clearfix"></div>
                                    </div>

                                    <div class="model_m p-3 clearfix border-top-0 text-center">
                                        <div class="float-start">
                                            <img src="uploads/<?= htmlspecialchars($trip['car_image']) ?>" class="card-img-top" alt="Car Image">
                                        </div>
                                        <div class="model_pg1i2 row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="model_pg1i2l">
                                                    <h4><?= htmlspecialchars($trip['car_house_name']) ?></h4>
													<p><?= htmlspecialchars($trip['car_name']) ?>-<?= htmlspecialchars($trip['car_capacity']) ?>chỗ</p>
                                                    <span class="font_12 col_yell">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="model_pg1i2r text-end">
                                                    <h3 class="mb-1"><i class=" col_oran"></i> <?= number_format($trip['price'], 0) ?> đ</h3>
                                                    <h6 class="mb-0 font_14">per day</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="model_pg1i3 row mt-4 mb-4 ">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="model_pg1i3l ">
                                                    <h6><i class="fa-solid fa-clock col_oran me-1"></i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/>
</svg><?= htmlspecialchars($trip['t_pick']) ?>-<?= htmlspecialchars($trip['city_from_name']) ?></h6>
                                                    <h6 class="mb-0 mt-3"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
</svg><?= htmlspecialchars($trip['t_drop']) ?> -<?= htmlspecialchars($trip['city_to_name']) ?>
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="model_pg1i3l text-end">
                                                    <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i>Còn  <?= htmlspecialchars($trip['remaining_seats']) ?> chỗ trống</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="model_pg1i4 row text-center mt-4">
											<p>*Vé chặng thuộc chuyến ngày <?= htmlspecialchars($date) ?>  <?= htmlspecialchars($trip['city_from_name']) ?> - <?= htmlspecialchars($trip['city_to_name']) ?></p>
                                            <div class="col-md-12">
											<h6 class="mb-0">
    <a class="buttonn button float-end" href="#"  >Book Ride <i class="fa fa-check-circle ms-1"></i></a>
</h6>
                                            </div>
											<div class="container mt-4">
    <div class="row">
        <!-- Điểm đón -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Điểm đón</h5>
                </div>
                <div class="card-body">
                    <form id="booking-form" action="booking_info.php?date=<?= htmlspecialchars($date) ?> " method="POST">
                        <input type="hidden" name="id_trip" value="<?= htmlspecialchars($trip['id_trip']) ?>">
                        <div class="pickup-locations overflow-auto" style="max-height: 300px;">
                            <?php foreach ($trip['pickup_locations'] as $location): ?>
                                <input type="hidden" name="pickup_name_<?= $location['id_location'] ?>" value="<?= htmlspecialchars($location['name_location']) ?>">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="pickup_location" id="pickup_<?= $location['id_location'] ?>" value="<?= $location['id_location'] ?>" required>
                                    <label class="form-check-label" for="pickup_<?= $location['id_location'] ?>">
                                        <strong><?= htmlspecialchars($location['time']) ?></strong> - <?= htmlspecialchars($location['name_location']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                </div>
            </div>
        </div>

        <!-- Điểm trả -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Điểm trả</h5>
                </div>
                <div class="card-body">
                    <div class="dropoff-locations overflow-auto" style="max-height: 300px;">
                        <?php foreach ($trip['dropoff_locations'] as $location): ?>
                            <div class="form-check mb-3">
                            <input type="hidden" name="dropoff_name_<?= $location['id_location'] ?>" value="<?= htmlspecialchars($location['name_location']) ?>">
                                <input class="form-check-input" type="radio" name="dropoff_location" id="dropoff_<?= $location['id_location'] ?>" value="<?= $location['id_location'] ?>" required>
                                <label class="form-check-label" for="dropoff_<?= $location['id_location'] ?>">
                                    <strong><?= htmlspecialchars($location['time']) ?></strong> - <?= htmlspecialchars($location['name_location']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Số lượng vé -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Số lượng vé</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ticket_quantity">Chọn số lượng vé:</label>
                        <input type="number" id="ticket_quantity" name="ticket_quantity" class="form-control" min="1" max="<?= htmlspecialchars($trip['remaining_seats']) ?>" placeholder="Nhập số lượng vé" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút đặt hàng -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Tiếp tục</button>
        </div>
    </div>
    </form>
</div>



                                        </div>
										
                                    </div>
									
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Không tìm thấy chuyến xe nào phù hợp.</p>
                <?php endif; ?>
            </div>
    </section>
</body>
</html>
<?php include('layout/footer.php'); ?>
<!-- <script>
     document.addEventListener('DOMContentLoaded', function () {
     const buttons = document.querySelectorAll('.buttonn');
    
    buttons.forEach(button => {
        button.addEventListener('click', function (event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
                const parentDiv = this.closest('.model_pg1i'); // Tìm div cha cần mở rộng
                 parentDiv.classList.toggle('expanded'); // Thêm hoặc xóa lớp 'expanded'
             });
         });
     });
</script> -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.buttonn');

        buttons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
                const parentDiv = this.closest('.model_pg1i'); // Tìm div cha cần mở rộng

                // Thêm hoặc xóa lớp 'expanded' để thay đổi chiều cao
                parentDiv.classList.toggle('expanded'); 

                // Đổi nội dung của nút
                if (this.textContent.trim() === 'Book Ride') {
                    this.innerHTML = 'Đóng <i class="fa fa-times ms-1"></i>';
                } else {
                    this.innerHTML = 'Book Ride <i class="fa fa-check-circle ms-1"></i>';
                }
            });
        });
    });
</script>

