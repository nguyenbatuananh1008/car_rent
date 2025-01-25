    <?php include_once 'navbar.php'; ?>
    <?php include_once 'slidebar.php'; ?>
    <?php include '../module/Database.php'; ?>
    <?php $db = new Database();
    $conn = $db->connectBee();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản lý lộ trình</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div id="layoutSidenav_content">
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>Quản lý lộ trình</h3>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Quản lý lộ trình</li>
                    </ol>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <form action="" method="get" class="input-group">
                            <input type="text" name="searchKeyword" value="<?php echo $_GET['searchKeyword'] ?? "" ?>" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm lộ trình">
                            <button type="submit" class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                            <i class="fas fa-plus"></i> Thêm mới
                        </button>
                    </div>
                </div>

                <!--  -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tạo lộ trình</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../module/location_p.php" method="POST">
                    <div class="mb-3">
                        <label for="trip_info" class="form-label">Chuyến xe</label>
                        <select class="form-select" id="trip_info" name="trip_info" required>
                            <?php
                            $query_trip = "
                                SELECT 
                                    trip.id_trip,
                                    car_house.name_c_house,
                                    car.c_plate,
                                    city_from.city_name AS city_from,
                                    city_to.city_name AS city_to
                                FROM 
                                    trip
                                INNER JOIN car ON trip.id_car = car.id_car
                                INNER JOIN car_house ON car.id_c_house = car_house.id_c_house
                                INNER JOIN city AS city_from ON trip.id_city_from = city_from.id_city
                                INNER JOIN city AS city_to ON trip.id_city_to = city_to.id_city";
                            $result_trip = $conn->query($query_trip);
                            while ($row_trip = $result_trip->fetch_assoc()) {
                                $id_trip = $row_trip['id_trip'];
                                $name_c_house = $row_trip['name_c_house'];
                                $c_plate = $row_trip['c_plate'];
                                $city_from = $row_trip['city_from'];
                                $city_to = $row_trip['city_to'];
                                echo "<option value='$id_trip'>$name_c_house - $c_plate - $city_from → $city_to</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3" id="location-container">
                        <label class="form-label">Danh sách vị trí</label>
                        <div class="d-flex align-items-center mb-2">
                            <input type="text" class="form-control" name="name_location[]" placeholder="Tên vị trí" required>
                            <input type="time" class="form-control ms-2" name="time_location[]" required>
                            <button type="button" class="btn btn-success ms-2" id="add-location">+</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="type_location" class="form-label">Loại địa điểm</label>
                        <select class="form-select" id="type_location" name="type_location" required>
                            <option value="0">Điểm đón</option>
                            <option value="1">Điểm trả</option>
                        </select>
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

                <!-- -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Sửa thông tin lộ trình</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="../module/location_p.php" method="POST">
                                    <input type="hidden" name="id_location" id="editId_location">
                                    <input type="hidden" name="id_trip" id="editId_trip">
                                    <div class="mb-3">
                                        <label for="edit_trip_info" class="form-label">Chuyến xe</label>
                                        <input type="text" class="form-control" id="edit_trip_info" name="trip_info" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_name_location" class="form-label">Tên vị trí</label>
                                        <input type="text" class="form-control" id="edit_name_location" name="name_location" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_time" class="form-label">Thời gian</label>
                                        <input type="time" class="form-control" id="edit_time" name="time" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_type_location" class="form-label">Loại địa điểm</label>
                                        <select class="form-select" id="edit_type_location" name="type_location" required>
                                            <option value="0">Điểm đón</option>
                                            <option value="1">Điểm trả</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="action" value="edit">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Xóa địa điểm</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Bạn có chắc chắn muốn xóa điểm này không?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="../module/location_p.php" method="POST">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id_location" id="deleteId_location">
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
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
                                <th>Thông tin chuyến xe</th>
                                <th>Tên vị trí</th>
                                <th>Thời gian</th>
                                <th>Loại địa điểm</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $search_keyword = $_GET['searchKeyword'] ?? '';
                            $query = "
                SELECT 
                    location.id_location,
                    CONCAT(car_house.name_c_house, ' - ', car.c_plate, ' - ', city_from.city_name, ' → ', city_to.city_name) AS trip_info,
                    location.name_location,
                    location.time,
                    CASE location.type
                        WHEN 0 THEN 'Điểm đón'
                        WHEN 1 THEN 'Điểm trả'
                    END AS type
                FROM 
                    location
                INNER JOIN trip ON location.id_trip = trip.id_trip
                INNER JOIN car ON trip.id_car = car.id_car
                INNER JOIN car_house ON car.id_c_house = car_house.id_c_house
                INNER JOIN city AS city_from ON trip.id_city_from = city_from.id_city
                INNER JOIN city AS city_to ON trip.id_city_to = city_to.id_city
                WHERE location.name_location LIKE ?";

                            $stmt = $conn->prepare($query);
                            $like_keyword = "%" . $search_keyword . "%";
                            $stmt->bind_param("s", $like_keyword);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                $stt = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                        <td>" . $stt++ . "</td>
                        <td>" . $row['trip_info'] . "</td>
                        <td>" . $row['name_location'] . "</td>
                        <td>" . $row['time'] . "</td>
                        <td>" . $row['type'] . "</td>
                        <td>
                            <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='" . $row['id_location'] . "'><i class='fas fa-edit'></i> Sửa</button>
                            <button class='btn btn-danger btn-sm btnDelete' data-id='" . $row['id_location'] . "'><i class='fas fa-trash-alt'></i> Xóa</button>
                        </td>
                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <script src="../js/location.js"></script>
    </body>

    </html>