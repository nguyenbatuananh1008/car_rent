<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php';
include '../module/auth.php';
checkAccess(1);  ?>
<?php
$db = new Database();
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
                <h3>Quản lý giá điểm dừng</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý giá điểm dừng</li>
                </ol>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm ">
                <button class="btn btn-outline-secondary" id="btnSearch">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>

            <!--Add -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập chuyến xe </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/trip_prices_p.php" method="POST" id="addTripPricesForm">
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
                                        <option value="" disabled selected>Chọn tuyến đường trước</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="car_info" class="form-label">Thông tin xe</label>
                                    <select class="form-select" id="car_info" name="id_car" required>
                                        <option value="" disabled selected>Chọn xe</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="car_plate" class="form-label">Biển số</label>
                                    <select class="form-select" id="car_plate" name="car_plate" required>
                                        <option value="" disabled selected>Chọn biển số</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="l_start" class="form-label">Điểm đón</label>
                                        <select class="form-select" id="l_start" name="l_start" required>
                                            <option value="" disabled selected>Chọn điểm đón</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="l_stop" class="form-label">Điểm trả</label>
                                        <select class="form-select" id="l_stop" name="l_stop" required>
                                            <option value="" disabled selected>Chọn điểm trả</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Nhập giá ( VNĐ )" required>
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

            <!-- Modal Sửa -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa chuyến xe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/trip_prices_p.php" method="POST" id="editTripPricesForm">
                                <input type="hidden" name="id_price" id="edit_id_price" value="">
                                <input type="hidden" name="id_route" id="edit_id_route" value="">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="edit_l_start" class="form-label">Điểm đón</label>
                                        <select class="form-select" id="edit_l_start" name="l_start" required>
                                            <option value="" disabled selected>Chọn điểm đón</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="edit_l_stop" class="form-label">Điểm trả</label>
                                        <select class="form-select" id="edit_l_stop" name="l_stop" required>
                                            <option value="" disabled selected>Chọn điểm trả</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" id="edit_price" name="price" placeholder="Nhập giá (VNĐ)" min="0" step="1000" required>
                                </div>
                                <input type="hidden" name="action" value="edit">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                            <h5 class="modal-title" id="deleteModalLabel">Xóa điểm dừng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn xóa điểm dừng này không?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="../module/trip_prices_p.php" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_price" id="deleteId_price">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            $query = "
        SELECT 
                tp.id_price,
                ch.name_c_house,
                tr.id_route,
                cRouteFrom.city_name AS route_city_from,
                cRouteTo.city_name AS route_city_to,
                cPickUp.city_name AS pickup_city,
                cDropOff.city_name AS dropoff_city,
                COALESCE(GROUP_CONCAT(DISTINCT cStop.city_name ORDER BY rs.type SEPARATOR ' → '), '') AS route_stops,
                tp.base_price
        FROM trip_prices tp
        JOIN trip tr ON tp.id_trip = tr.id_trip
        JOIN car_house ch ON tr.id_c_house = ch.id_c_house
        JOIN route r ON tr.id_route = r.id_route
            -- Lấy điểm đầu và cuối của tuyến đường từ bảng route
        JOIN city cRouteFrom ON r.id_city_from = cRouteFrom.id_city
        JOIN city cRouteTo ON r.id_city_to = cRouteTo.id_city
            -- Lấy điểm đón và trả từ bảng trip_prices
        JOIN city cPickUp ON tp.id_city_from = cPickUp.id_city
        JOIN city cDropOff ON tp.id_city_to = cDropOff.id_city
            -- Lấy danh sách điểm dừng từ bảng route_stop
        LEFT JOIN route_stop rs ON r.id_route = rs.id_route
        LEFT JOIN city cStop ON rs.id_city = cStop.id_city
        GROUP BY 
                tp.id_price,
                ch.name_c_house, 
                tr.id_route, 
                cRouteFrom.city_name,
                cRouteTo.city_name,
                cPickUp.city_name,
                cDropOff.city_name,
                tp.base_price ";
            $result = $conn->query($query);
            ?>

            <div class="text-center">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã giá</th>
                            <th>Nhà xe</th>
                            <th>Tuyến đường</th>
                            <th>Điểm dừng</th>
                            <th>Giá</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id_price']; ?></td>
                                <td><?php echo $row['name_c_house']; ?></td>
                                <td>
                                    <?php
                                    $routeDisplay = $row['route_city_from'];
                                    if (!empty($row['route_stops'])) {
                                        $routeDisplay .= ' → ' . $row['route_stops'];
                                    }
                                    $routeDisplay .= ' → ' . $row['route_city_to'];
                                    echo $routeDisplay;
                                    ?>
                                </td>
                                <td><?php echo $row['pickup_city'] . ' → ' . $row['dropoff_city']; ?></td>
                                <td><?php echo number_format($row['base_price'], 0, ',', '.'); ?> VNĐ</td>
                                <td>
                                    <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='<?php echo $row['id_price']; ?>'>
                                        <i class='fas fa-edit'></i> Sửa
                                    </button>
                                    <button class='btn btn-danger btn-sm btnDelete' data-id='<?php echo $row['id_price']; ?>'>
                                        <i class='fas fa-trash-alt'></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="../js/trip_prices.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>