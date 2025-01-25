<?php include_once 'navbar.php'; ?>
    <?php include_once 'slidebar.php'; ?>
    <?php include '../module/Database.php'; ?>
    <?php include '../module/formart.php'; ?>
    <?php $db = new Database();
    $conn = $db->connectBee();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản lý tyến xe</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>

    <body>
        <div id="layoutSidenav_content">
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Danh sách chuyến xe</h3>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Quản lý chuyến xe</li>
                    </ol>
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm ">
                    <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                    <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fas fa-plus"></i> Thêm mới
                    </button>
                </div>

                 <!-- add -->
                 <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Nhập chuyến xe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="../module/trip_p.php" method="POST">
                                    <div class="mb-3">
                                        <label for="name_c_house" class="form-label">Nhà xe</label>
                                        <select class="form-select" id="name_c_house" name="name_c_house" required>
                                            <?php
                                            $query_c_house = "SELECT id_c_house, name_c_house FROM car_house";
                                            $result_c_house = $conn->query($query_c_house);
                                            while ($row_c_house = $result_c_house->fetch_assoc()) {
                                                echo "<option value='{$row_c_house['id_c_house']}'>{$row_c_house['name_c_house']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="c_plate" class="form-label">Biển số</label>
                                        <select class="form-select" id="c_plate" name="c_plate" required>
                                            <option value="c_plate" disabled selected>Chọn nhà xe trước</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="id_city_from" class="form-label">Điểm đón</label>
                                        <select class="form-select" id="id_city_from" name="id_city_from" required>
                                            <?php
                                            $query_city_from = "SELECT id_city, city_name FROM city";
                                            $result_city_from = $conn->query($query_city_from);
                                            while ($row_city_from = $result_city_from->fetch_assoc()) {
                                                echo "<option value='{$row_city_from['id_city']}'>{$row_city_from['city_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_city_to" class="form-label">Điểm trả</label>
                                        <select class="form-select" id="id_city_to" name="id_city_to" required>
                                            <?php
                                            $query_city_to = "SELECT id_city, city_name FROM city";
                                            $result_city_to = $conn->query($query_city_to);
                                            while ($row_city_to = $result_city_to->fetch_assoc()) {
                                                echo "<option value='{$row_city_to['id_city']}'>{$row_city_to['city_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="t_pick" class="form-label">Giờ đón</label>
                                        <input type="time" class="form-control timepicker" id="t_pick" name="t_pick" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="t_drop" class="form-label">Giờ trả</label>
                                        <input type="time" class="form-control timepicker" id="t_drop" name="t_drop" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="t_limit" class="form-label">Số vé</label>
                                        <input type="number" class="form-control" id="t_limit" name="t_limit" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="price" class="form-label">Giá</label>
                                        <input type="text" class="form-control" id="price" name="price" required>
                                    </div>
                                    <input type="hidden" name="action" value="add">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                 <!--  -->
                 <div class="text-center">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Nhà xe</th>
                                <th>Tuyến đường</th>
                                <th>Loại xe</th>
                                <th>Giờ đón</th>
                                <th>Giờ trả</th>
                                <th>Số vé</th>
                                 <th>Giá</th>           
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                <script src="../js/trip.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <? require 'footer.php'; ?>