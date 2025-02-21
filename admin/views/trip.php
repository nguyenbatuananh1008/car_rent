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
    <title>Quản lý tuyến xe</title>
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

            <!--Add -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập chuyến xe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/trip_p.php" method="POST" id="addTripForm">
                                <div class="mb-3">
                                    <label for="name_c_house" class="form-label">Nhà xe</label>
                                    <select class="form-select" id="name_c_house" name="id_c_house" required>
                                        <option value="" disabled selected>Chọn nhà xe</option>
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
                                    <label for="id_route" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="id_route" name="id_route" required>
                                        <option value="" disabled selected>Chọn nhà xe trước</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="car_info" class="form-label">Thông tin xe</label>
                                    <select class="form-select" id="car_info" name="id_car" required>
                                        <option value="" disabled selected>Chọn nhà xe trước</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="car_plate" class="form-label">Biển số</label>
                                    <select class="form-select" id="car_plate" name="car_plate" required>
                                        <option value="" disabled selected>Chọn xe trước</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="t_pick" class="form-label">Giờ đón</label>
                                        <input type="time" class="form-control" id="t_pick" name="t_pick" required>
                                    </div>
                                    <div class="col">
                                        <label for="t_drop" class="form-label">Giờ trả</label>
                                        <input type="time" class="form-control" id="t_drop" name="t_drop" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="t_limit" class="form-label">Số vé</label>
                                        <input type="number" class="form-control" id="t_limit" name="t_limit" required>
                                    </div>
                                    <div class="col">
                                        <label for="price" class="form-label">Giá</label>
                                        <input type="text" class="form-control" id="price" name="price" required>
                                    </div>
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

            <!--Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa thông tin chuyến xe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/trip_p.php" method="POST">
                                <input type="hidden" name="id_trip" id="edit_Id_trip">
                                <div class="mb-3">
                                    <label for="edit_name_c_house" class="form-label">Nhà xe</label>
                                    <select class="form-select" id="edit_name_c_house" name="id_c_house" required>
                                        <option value="" disabled selected>Chọn nhà xe</option>
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
                                    <label for="edit_id_route" class="form-label">Tuyến đường</label>
                                    <select class="form-select" id="edit_id_route" name="id_route" required>
                                        <option value="" disabled selected>Chọn nhà xe trước</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_car_info" class="form-label">Thông tin xe</label>
                                    <select class="form-select" id="edit_car_info" name="id_car" required>
                                        <option value="" disabled selected>Chọn nhà xe trước</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_car_plate" class="form-label">Biển số</label>
                                    <select class="form-select" id="edit_car_plate" name="car_plate" required>
                                        <option value="" disabled selected>Chọn xe trước</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="edit_t_pick" class="form-label">Giờ đón</label>
                                        <input type="time" class="form-control" id="edit_t_pick" name="t_pick" required>
                                    </div>

                                    <div class="col">
                                        <label for="edit_t_drop" class="form-label">Giờ trả</label>
                                        <input type="time" class="form-control" id="edit_t_drop" name="t_drop" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_t_limit" class="form-label">Số vé</label>
                                    <input type="number" class="form-control" id="edit_t_limit" name="t_limit" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Giá</label>
                                    <input type="text" class="form-control" id="edit_price" name="price" required>
                                </div>
                                <input type="hidden" name="action" value="edit">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
                            <p>Bạn có chắc chắn muốn xóa tuyến đường này không?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="../module/trip_p.php" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_trip" id="deleteId_trip">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--Search -->
            <div class="text-center">
                <table class="table table-bordered table-hover">
                    <?php
                    $searchKeyword = $_GET['searchKeyword'] ?? '';

                    $query = "SELECT t.id_trip, ch.name_c_house, r.id_route, c.id_car, c.c_plate,
                                     cf.city_name AS city_from, ct.city_name AS city_to, 
                                     c.c_name, c.c_type, c.c_color, c.c_plate, 
                                     t.t_pick, t.t_drop, t.t_limit, t.price
                              FROM trip t
                              JOIN car_house ch ON t.id_c_house = ch.id_c_house
                              JOIN route r ON t.id_route = r.id_route
                              JOIN city cf ON r.id_city_from = cf.id_city
                              JOIN city ct ON r.id_city_to = ct.id_city
                              JOIN car c ON t.id_car = c.id_car";

                    if (!empty($searchKeyword)) {
                        $query .= " WHERE ch.name_c_house LIKE ? OR t.id_trip = ? OR ch.id_c_house = ?";
                    }
                    $query .= " ORDER BY t.id_trip DESC";

                    $stmt = $conn->prepare($query);

                    if (!empty($searchKeyword)) {
                        $like_keyword = "%$searchKeyword%";
                        $stmt->bind_param("sii", $like_keyword, $searchKeyword, $searchKeyword);
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>
                    <thead class="table-dark">
                        <tr>
                            <th>Mã</th>
                            <th>Nhà xe</th>
                            <th>Tuyến đường</th>
                            <th>Thông tin xe</th>
                            <th>Biển số</th>
                            <th>Giờ đón</th>
                            <th>Giờ trả</th>
                            <th>Số vé</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id_trip']}</td>";
                                echo "<td>{$row['name_c_house']}</td>";
                                echo "<td>{$row['city_from']} → {$row['city_to']}</td>";
                                echo "<td>{$row['c_name']} - {$row['c_type']} - {$row['c_color']}</td>";
                                echo "<td>{$row['c_plate']}</td>";
                                echo "<td>" . date("H:i", strtotime($row['t_pick'])) . "</td>";
                                echo "<td>" . date("H:i", strtotime($row['t_drop'])) . "</td>";
                                echo "<td>{$row['t_limit']}</td>";
                                echo "<td>" . formatMoney($row['price']) . "</td>";
                                echo "<td>
                <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='" . $row['id_trip'] . "'><i class='fas fa-edit'></i> Sửa</button>
                <button class='btn btn-danger btn-sm btnDelete' data-id='" . $row['id_trip'] . "'><i class='fas fa-trash-alt'></i> Xóa</button>
              </td>";
                                echo "</tr>";
                            }
                        } else if ($result->num_rows == 0) {
                            echo "<tr><td colspan='10' class='text-center'>Không có dữ liệu</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/trip.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<?php require 'footer.php'; ?>

</html>