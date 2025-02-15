    <?php
    require_once 'module/TripSearcher.php';

    $city_from = $_GET['city_from'] ?? null;
    $city_to = $_GET['city_to'] ?? null;
    $date = $_GET['date'] ?? null;
    $sort = $_GET['sort'] ?? 'default';

    if ($date) {
        $date = DateTime::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    } else {
        $date = null;
    }

    $tripSearcher = new TripSearcher();
    $trips = [];
    
    if ($city_from && $city_to && $date) {
        $trips = $tripSearcher->searchTrips($city_from, $city_to, $date, $sort);

        if (empty($trips)) {
            echo "<p class='text-danger'>Không có chuyến xe nào tìm thấy.</p>";
        } else {
            // Tính toán số ghế còn lại và lọc chuyến xe
            $trips = array_filter(array_map(function ($trip) use ($tripSearcher, $date) {
                $number_seat = $tripSearcher->numberSeat($trip['id_trip'], $date);
                $remaining_seats = (int) $trip['remaining_seats'] - (int) $number_seat;
                $trip['remaining_seats'] = $remaining_seats;
           
                return $trip;
            }, $trips), function ($trip) {
                return $trip['remaining_seats'] > 0;
            });
        }
       
    }





    include('layout/header.php');
    ?>



        <style>
       .model_pg1i {
    overflow: hidden;
    max-height: 470px; /* Trạng thái collapsed: nếu nội dung nhỏ hơn 450px, nó vẫn hiển thị đúng */
    transition: max-height 0.5s ease;
}

/* Khi mở rộng, đặt max-height cao hơn dự kiến (ví dụ 3000px) để đảm bảo hiển thị hết nội dung */
.model_pg1i.expanded {
    max-height: 3000px;
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
                    <div class="row">
                        <!-- Bộ lọc -->
                        <div class="col-md-3">
                            <form method="GET" action="trip_results.php">
                                <input type="hidden" name="city_from" value="<?= htmlspecialchars($city_from) ?>">
                                <input type="hidden" name="city_to" value="<?= htmlspecialchars($city_to) ?>">
                                <input type="hidden" name="date" value="<?= htmlspecialchars($date) ?>">
                                
                                <div class="filter-section">
                                    <h5>Sắp xếp</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort" value="default"
                                            <?= ($sort == 'default') ? 'checked' : '' ?>>
                                        <label class="form-check-label">Mặc định</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort" value="earliest"
                                            <?= ($sort == 'earliest') ? 'checked' : '' ?>>
                                        <label class="form-check-label">Giờ đi sớm nhất</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort" value="latest"
                                            <?= ($sort == 'latest') ? 'checked' : '' ?>>
                                        <label class="form-check-label">Giờ đi muộn nhất</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort" value="price_asc"
                                            <?= ($sort == 'price_asc') ? 'checked' : '' ?>>
                                        <label class="form-check-label">Giá tăng dần</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sort" value="price_desc"
                                            <?= ($sort == 'price_desc') ? 'checked' : '' ?>>
                                        <label class="form-check-label">Giá giảm dần</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Lọc</button>

                                </div>
                            </form>
                        </div>

                        <div class="col-md-9">

                            <?php if (!empty($trips)): ?>
                                <p class="text-success">Tìm thấy <strong><?= count($trips) ?></strong> chuyến xe phù hợp.</p>
                                <div class="row">   
                                <?php foreach ($trips as $trip ): ?>
    <form class="booking-form" action="booking_info.php?date=<?= htmlspecialchars($date) ?>" method="POST">
        <div class="col-md-12 shadow-lg p-3 mb-5 bg-white rounded ms-auto mb-4">
            <div class="model_pg1i clearfix"> 
                                                    <div class="model_pg1i1">
                                                        <div class="grid clearfix"></div>
                                                    </div>
                                                    <input type="hidden" name="id_trip"value="<?= htmlspecialchars($trip['id_trip']) ?>">
                                                    <input type="hidden" name="car_name" value="<?= htmlspecialchars($trip['car_name']) ?>">
                                                    <input type="hidden" name="full_route" value="<?= htmlspecialchars($trip['full_route'] ?? 'Không xác định') ?>">
                                                    <input type="hidden" name="route_id" value="<?= htmlspecialchars($trip['id_route']) ?>">
                                                    <input type="hidden" name="car_capacity" value="<?= htmlspecialchars($trip['car_capacity']) ?>">
                                                    <input type="hidden" name="city_location" value="<?= htmlspecialchars($pickup['city_name']) ?>">
                                                    <input type="hidden" name="car_image" value="<?= htmlspecialchars($trip['car_image']) ?>">
                                                    <input type="hidden" name="car_type" value="<?= htmlspecialchars($trip['car_type']) ?>">
                                                    <input type="hidden" name="car_color" value="<?= htmlspecialchars($trip['car_color']) ?>">
                                                    <input type="hidden" name="car_house_name"value="<?= htmlspecialchars($trip['car_house_name']) ?>">
                                                    <input type="hidden" name="city_from" value="<?= htmlspecialchars($city_from) ?>">
                                                    <input type="hidden" name="city_to" value="<?= htmlspecialchars($city_to) ?>">
                                                    <input type="hidden" name="city_from_name"
                                                        value="<?= htmlspecialchars($trip['city_from_name']) ?>">
                                                    <input type="hidden" name="city_to_name"
                                                        value="<?= htmlspecialchars($trip['city_to_name']) ?>">
                                                        
                                                    <div class="model_m p-3 clearfix border-top-0 text-center">
                                                        <div class="float-start">
                                                            <img src="admin/uploads/<?= htmlspecialchars($trip['car_image']) ?>"
                                                                class="card-img-top" alt="Car Image"
                                                                style="width: 200px; height: 100px;">
                                                        </div>
                                                        <div class="model_pg1i2 row">
                                                            <div class="col-md-9 col-sm-6">
                                                                <div class="model_pg1i2l">
                                                                    <h4><?= htmlspecialchars($trip['car_house_name']) ?></h4>
                                                                   <p> <strong>Thông tin xe :</strong><?= htmlspecialchars($trip['car_name']) ?>(<?= htmlspecialchars($trip['car_color']) ?>) -<?= htmlspecialchars($trip['car_type']) ?>-
                                                                        <?= htmlspecialchars($trip['car_capacity']) ?> chỗ</p>
                                                

                                                                    <?= isset($trip['full_route']) ? htmlspecialchars($trip['full_route']) : 'Không xác định' ?>

                                                                    <ul>
                                                                        <?php foreach ($trip['segment_prices'] as $segment): ?>
                                                                            <li>
                                                                                <?= htmlspecialchars($segment['city_from_name']) ?> →
                                                                                <?= htmlspecialchars($segment['city_to_name']) ?> :
                                                                                <strong><?= number_format($segment['base_price'], 0) ?>
                                                                                    đ</strong>
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul>
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
                                                            <div class="col-md-3 col-sm-6">

                                                                <div class="model_pg1i3l ">
                                                                    <h5><i class="fa-solid fa-clock col_oran me-1"></i><svg
                                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                            fill="currentColor" class="bi bi-geo-fill"
                                                                            viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd"
                                                                                d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411" />
                                                                        </svg><?= htmlspecialchars($trip['t_pick']) ?>-<?= htmlspecialchars($trip['city_from_name']) ?>
                                                                    </h5>
                                                                    <h5 class="mb-0 mt-3"><svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                                                        </svg><?= htmlspecialchars($trip['t_drop']) ?>
                                                                        -<?= htmlspecialchars($trip['city_to_name']) ?>
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 col-sm-6">
                                                                <div class="model_pg1i3l text-end">
                                                                    <h6 class="mb-0"><i class="fa fa-female col_oran me-1"></i>Còn
                                                                        <?= htmlspecialchars($trip['remaining_seats']) ?> chỗ trống</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="model_pg1i4 row text-center mt-4">
                                                            <p>*Vé chặng thuộc chuyến ngày
                                                                <?= date("d/m/Y", strtotime($date)) . "" . htmlspecialchars($trip['city_from_name']) . "-" . htmlspecialchars($trip['city_to_name']) ?>
                                                            </p>

                                                            <div class="col-md-12">
                                                                <h6 class="mb-0">
                                                                    <a class="buttonn button float-end" href="#">Đặt vé <i
                                                                    class="fa fa-check-circle ms-1"></i></a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-5">
    <label for="num_seats_<?= $trip['id_route'] ?>">Số lượng ghế:</label>
    <input type="number" id="num_seats_<?= $trip['id_route'] ?>" 
           name="num_seats_<?= $trip['id_route'] ?>" 
           min="1" 
           max="<?= htmlspecialchars($trip['remaining_seats']) ?>" 
           value="1" 
           class="seat-input" 
           onkeydown="return false;">
    <small class="text-muted">Tối đa <?= htmlspecialchars($trip['remaining_seats']) ?> ghế</small>
</div>

                                                    <div class="d-flex justify-content-between mt-5">
        <!-- Chọn điểm đón (bên trái) -->
        <div class="pickup-locations" style="flex: 1; padding-right: 20px;">
            <h5>📍 Chọn điểm đón:</h5>
            <?php foreach ($tripSearcher->getPickupLocations($trip['id_route']) as $pickup): ?>
                <div class="form-check">
                    <input class="form-check-input pickup-radio" type="radio" name="pickup_<?= $trip['id_route'] ?>"
                        value="<?= htmlspecialchars($pickup['name_location']) . '||' . htmlspecialchars($pickup['city_name']) . '||' . htmlspecialchars($pickup['pickup_time'])?>" data-trip="<?= $trip['id_trip'] ?>"
                        data-city-id="<?= htmlspecialchars($pickup['id_city']) ?>"required>
                    <label class="form-check-label">
                        <?= htmlspecialchars($pickup['name_location']) ?> (<?= htmlspecialchars($pickup['city_name']) ?>)- 
                        <strong><?= htmlspecialchars($pickup['pickup_time']) ?></strong>
                        
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Chọn điểm trả (bên phải) -->
        <div class="dropoff-locations" style="flex: 1; padding-left: 20px;">
            <h5>📍 Chọn điểm trả:</h5>
            <?php foreach ($tripSearcher->getDropoffLocations($trip['id_route']) as $dropoff): ?>
                <div class="form-check">
                    <input class="form-check-input dropoff-radio" type="radio" name="dropoff_<?= $trip['id_route'] ?>"
                        value="<?= htmlspecialchars($dropoff['name_location']) . '||' . htmlspecialchars($dropoff['city_name']).'||' . htmlspecialchars($dropoff['dropoff_time']) ?>" data-trip="<?= $trip['id_trip'] ?>"
                        data-city-id="<?= htmlspecialchars($dropoff['id_city']) ?>"required>
                    <label class="form-check-label">    
                        <?= htmlspecialchars($dropoff['name_location']) ?> (<?= htmlspecialchars($dropoff['city_name']) ?>)- 
                        <strong><?= htmlspecialchars($dropoff['dropoff_time']) ?></strong>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <hr>
    <!-- Khối hiển thị ghế & giá & nút "Tiếp tục" -->
<div class="row mt-3">
    <div class="col-md-12 d-flex justify-content-end align-items-center">
        <!-- Hiển thị số ghế -->
        <div class="me-4">
            Ghế: <strong id="seat_count_<?= $trip['id_trip'] ?>">0</strong> Khách
        </div>

        <!-- Hiển thị tổng giá -->
        <div class="me-4">
            Tổng cộng: <strong id="total_price_<?= $trip['id_trip'] ?>">0</strong> đ
            <input type="hidden" name="total_price" id="hidden_total_price_<?= $trip['id_trip'] ?>" value="0">
        </div>

        <!-- Nút tiếp tục -->
        <button type="submit" class=" continue-button btn btn-primary">
            Tiếp tục
        </button>
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

    

  <script>
document.addEventListener('DOMContentLoaded', function () {
    const bookingForms = document.querySelectorAll('.booking-form');
    
    bookingForms.forEach(form => {
        const pickupRadios = form.querySelectorAll('.pickup-radio');
        const dropoffRadios = form.querySelectorAll('.dropoff-radio');
        const seatInput = form.querySelector('.seat-input');
        const continueButton = form.querySelector('.continue-button'); // Giả sử nút tiếp tục có lớp 'continue-button'

        function updatePrice() {
            // Lấy số ghế đã chọn từ ô input
            const selectedNumSeats = parseInt(seatInput.value) || 1;
            
            // Cập nhật hiển thị số ghế (giả sử sử dụng tripId từ radio)
            const anyPickup = form.querySelector('.pickup-radio');
            if (anyPickup) {
                const tripId = anyPickup.getAttribute('data-trip');
                form.querySelector('#seat_count_' + tripId).textContent = selectedNumSeats;
            }

            // Nếu đã chọn điểm đón và điểm trả, tiến hành lấy giá vé
            const selectedPickup = form.querySelector('.pickup-radio:checked');
            const selectedDropoff = form.querySelector('.dropoff-radio:checked');
            if (selectedPickup && selectedDropoff) {
                const pickupCityId = selectedPickup.getAttribute('data-city-id');
                const dropoffCityId = selectedDropoff.getAttribute('data-city-id');
                const tripId = selectedPickup.getAttribute('data-trip');

                fetch(`module/trip_price.php?pickup_city_id=${pickupCityId}&dropoff_city_id=${dropoffCityId}&trip_id=${tripId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const totalPrice = data.price * selectedNumSeats;
                            // Cập nhật hiển thị tổng giá
                            form.querySelector('#total_price_' + tripId).textContent = 
                                new Intl.NumberFormat().format(totalPrice);
                            // Cập nhật trường hidden để chuyển sang trang sau
                            form.querySelector('#hidden_total_price_' + tripId).value = totalPrice;

                            // Kích hoạt nút tiếp tục nếu có giá
                            continueButton.disabled = false;
                        } else {
                            form.querySelector('#total_price_' + tripId).textContent = 'Không có giá cho lộ trình này';
                            // Vô hiệu hóa nút tiếp tục nếu không có giá
                            continueButton.disabled = true;
                        }
                    })
                    .catch(error => {
                        form.querySelector('#total_price_' + tripId).textContent = 'Lỗi';
                        // Vô hiệu hóa nút tiếp tục khi có lỗi
                        continueButton.disabled = true;
                        console.error('Error fetching price:', error);
                    });
            }
        }

        // Lắng nghe sự kiện thay đổi (do sử dụng spinner, sự kiện 'input' vẫn hoạt động)
        seatInput.addEventListener('input', updatePrice);

        // Ngoài ra, nếu bạn thay đổi điểm đón/điểm trả thì cập nhật lại giá
        pickupRadios.forEach(radio => radio.addEventListener('change', updatePrice));
        dropoffRadios.forEach(radio => radio.addEventListener('change', updatePrice));

        // Cập nhật ngay khi load trang để đảm bảo hiển thị đúng (số ghế = 1, tổng giá nếu có)
        updatePrice();
    });
});


</script>

        <?php include('layout/footer.php'); ?>
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
                        if (this.textContent.trim() === 'Đặt vé') {
                            this.innerHTML = 'Đóng <i class="fa fa-times ms-1"></i>';
                        } else {
                            this.innerHTML = 'Đặt vé <i class="fa fa-check-circle ms-1"></i>';
                        }
                    });
                });
            });
        </script>