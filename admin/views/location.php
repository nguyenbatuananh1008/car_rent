<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php'; ?>
<?php
$db = new Database();
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

            <!-- Add -->
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
                                    <label for="route_info" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="route_info" name="route_info" required>
                                        <?php
                                        $query_route = "
                                        SELECT 
                                            route.id_route,
                                            car_house.name_c_house,
                                            city_from.city_name AS city_from,
                                            city_to.city_name AS city_to
                                        FROM 
                                            route
                                        INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
                                        INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
                                        INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city";

                                        $result_route = $conn->query($query_route);
                                        while ($row_route = $result_route->fetch_assoc()) {
                                            $id_route = $row_route['id_route'];
                                            $name_c_house = $row_route['name_c_house'];
                                            $city_from = $row_route['city_from'];
                                            $city_to = $row_route['city_to'];
                                            echo "<option value='$id_route'>$name_c_house - $city_from → $city_to</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3" id="location-container">
                                    <label class="form-label">Danh sách vị trí</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <input type="text" class="form-control" name="name_location[]" placeholder="Tên địa điểm" required>
                                        <input list="city_list" class="form-control ms-2" id="city_name" name="city_name[]" placeholder="Tên thành phố" required>
                                        <datalist id="city_list">
                                            <?php
                                            $query_city = "SELECT id_city, city_name FROM city";
                                            $result_city = $conn->query($query_city);
                                            while ($row_city = $result_city->fetch_assoc()) {
                                                echo "<option value='{$row_city['id_city']}'>{$row_city['city_name']}</option>";
                                            }
                                            ?>
                                        </datalist>
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

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin lộ trình</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/location_p.php" method="POST">
                                <input type="hidden" id="editId_location" name="id_location">

                                <div class="mb-3">
                                    <label for="edit_route_info" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="edit_route_info" name="id_route" required>
                                        <?php
                                        $query_route = "
                            SELECT 
                                route.id_route,
                                car_house.name_c_house,
                                city_from.city_name AS city_from,
                                city_to.city_name AS city_to
                            FROM 
                                route
                            INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
                            INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
                            INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city";

                                        $result_route = $conn->query($query_route);
                                        while ($row_route = $result_route->fetch_assoc()) {
                                            echo "<option value='{$row_route['id_route']}'>{$row_route['name_c_house']} - {$row_route['city_from']} → {$row_route['city_to']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3" id="location-container">
                                    <label class="form-label">Danh sách vị trí</label>
                                    <div class="d-flex align-items-center mb-2">
                                        <input type="text" class="form-control" id="edit_name_location" name="name_location[]" placeholder="Tên vị trí" required>
                                        <select class="form-select ms-2" id="edit_city_name" name="id_city[]" required>
                                            <?php
                                            $query_city = "SELECT id_city, city_name FROM city";
                                            $result_city = $conn->query($query_city);
                                            while ($row_city = $result_city->fetch_assoc()) {
                                                echo "<option value='{$row_city['id_city']}'>{$row_city['city_name']}</option>";
                                            }
                                            ?>
                                        </select>
                                        <input type="time" id="edit_time" class="form-control ms-2" name="time_location[]" required>
                                    </div>
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


            <!-- Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Xóa tuyến đường</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa địa điểm này không?</p>
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

            <!-- Table -->
            <div class="text-center">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Chuyến xe</th>
                            <th>Địa điểm</th>
                            <th>Thành phố</th>
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
        route.id_route,
        location.id_city,
        location.time,
        location.type,
        location.name_location,
        CONCAT(car_house.name_c_house, ' - ', city_from.city_name, ' → ', city_to.city_name) AS route_info,
        city.city_name AS city_name 
    FROM location
    INNER JOIN route ON location.id_route = route.id_route
    INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
    INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city
    INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city
    INNER JOIN city ON location.id_city = city.id_city
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
                <td>" . $row['route_info'] . "</td>
                <td>" . $row['name_location'] . "</td>  
                <td>" . $row['city_name'] . "</td> 
                <td>" . date("H:i", strtotime($row['time'])) . "</td>
                <td>" . ($row['type'] == 0 ? 'Điểm đón' : 'Điểm trả') . "</td>
                <td>
                    <button class='btn btn-warning btn-sm me-1 btnEdit'
                        data-id='" . $row['id_location'] . "'
                        data-route='" . $row['id_route'] . "'
                        data-name='" . $row['name_location'] . "'
                        data-city='" . $row['id_city'] . "'
                        data-time='" . $row['time'] . "'
                        data-type='" . $row['type'] . "'
                        data-bs-toggle='modal' data-bs-target='#editModal'>
                        <i class='fas fa-edit'></i> Sửa
                    </button>

                    <button class='btn btn-danger btn-sm btnDelete' data-id='" . $row['id_location'] . "'>
                        <i class='fas fa-trash-alt'></i> Xóa
                    </button>
                </td>
            </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/location.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</html>