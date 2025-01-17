<?php
require_once 'module/db.php';

// Lấy danh sách các thành phố từ cơ sở dữ liệu
$db = new Database();
$conn = $db->connect();
$query = $conn->query("SELECT * FROM city");
$cities = $query->fetchAll(PDO::FETCH_ASSOC);
$city_from = isset($city_from) ? $city_from : null;
$city_to = isset($city_to) ? $city_to : null;
$date = isset($date) ? $date : null;
?>
?>


<div class="container-xl shadow-lg p-3 mb-5 bg-white rounded">
    <div class="booking_m clearfix bg-white">
        <form action="trip.php" method="GET">
            <div class="row booking_1 mb-4">
                <div class="col-md-12">
                    <h4 class="mb-0">Tìm chuyến xe</h4>
                </div>
            </div> 
            <div class="row booking_2 align-items-center">
                <div class="col-md-3 col-sm-6">
                    <div class="booking_2i">
                        <h6 class="mb-3"><i class="fa fa-map-marker me-1 col_oran"></i> Điểm đi</h6>
                        <select class="form-select" name="city_from" required>
                            <option value="">Chọn điểm đi</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= $city['id_city'] ?>" <?= ($city_from == $city['id_city']) ? 'selected' : '' ?>>  
                                    <?= htmlspecialchars($city['name_city']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="booking_2i">
                        <h6 class="mb-3"><i class="fa fa-map-marker me-1 col_oran"></i> Điểm đến</h6>
                        <select class="form-select" name="city_to" required>
                            <option value="">Chọn điểm đến</option>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= $city['id_city'] ?>" <?= ($city_to == $city['id_city']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($city['name_city']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="booking_2i">
                        <h6 class="mb-3"><i class="fa fa-calendar me-1 col_oran"></i> Ngày đi</h6>
                        <input class="form-control" type="date" name="date" value="<?= htmlspecialchars($date) ?>" required>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 text-center">
                    <div class="booking_2i">
                        <h6 class="mb-3"><i class="fa fa-search me-1 col_oran"></i> Tìm</h6>
                        <button type="submit" class="button pt-2 pb-2 ps-4 pe-4 d-inline-block w-100">Tìm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
