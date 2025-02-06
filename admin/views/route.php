<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php'; ?>
<?php include '../module/formart.php'; ?>
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
                <h3>Danh sách tuyến đường</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý tuyến đường</li>
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


            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập tuyến đường</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/route_p.php" method="POST">
                                <div class="mb-3">
                                    <label for="id_c_house" class="form-label">Nhà xe</label>
                                    <select class="form-select" id="id_c_house" name="id_c_house" required>
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

                                <input type="hidden" name="action" value="add">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa thông tin tuyến đường</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/route_p.php" method="POST">
                                <input type="hidden" name="id_route" id="editId_route">

                                <div class="mb-3">
                                    <label for="edit_id_c_house" class="form-label">Nhà xe</label>
                                    <select class="form-select" id="edit_id_c_house" name="id_c_house" required>
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
                                    <label for="edit_id_city_from" class="form-label">Điểm đón</label>
                                    <select class="form-select" id="edit_id_city_from" name="id_city_from" required>
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
                                    <label for="edit_id_city_to" class="form-label">Điểm trả</label>
                                    <select class="form-select" id="edit_id_city_to" name="id_city_to" required>
                                        <?php
                                        $query_city_to = "SELECT id_city, city_name FROM city";
                                        $result_city_to = $conn->query($query_city_to);
                                        while ($row_city_to = $result_city_to->fetch_assoc()) {
                                            echo "<option value='{$row_city_to['id_city']}'>{$row_city_to['city_name']}</option>";
                                        }
                                        ?>
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
                            <form action="../module/route_p.php" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_route" id="deleteId_route">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã</th>
                            <th>Nhà xe</th>
                            <th>Điểm đón</th>
                            <th>Điểm trả</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $searchKeyword = $_POST['search_keyword'] ?? '';
                        $query = "
                                SELECT 
                                    t.id_route,
                                    ch.name_c_house AS TenNhaXe,
                                    cf.city_name AS DiemDon,
                                    ct.city_name AS DiemTra,
                                    t.date AS Ngay,
                                    t.id_route AS MaChuyenXe
                                FROM 
                                    route t
                                JOIN 
                                    car_house ch ON t.id_c_house = ch.id_c_house
                                JOIN 
                                    city cf ON t.id_city_from = cf.id_city
                                JOIN 
                                    city ct ON t.id_city_to = ct.id_city";

                        if ($searchKeyword) {
                            $query .= " WHERE 
                                    ch.name_c_house LIKE ? OR
                                    cf.city_name LIKE ? OR
                                    ct.city_name LIKE ? OR
                                    t.date LIKE ? ";
                                    
                        }

                        $stmt = $conn->prepare($query);

                        if ($stmt) {
                            if ($searchKeyword) {
                                $searchKeywordParam = '%' . $searchKeyword . '%';
                                $stmt->bind_param('ssss', $searchKeywordParam, $searchKeywordParam, $searchKeywordParam, $searchKeywordParam);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                                <td>{$row['MaChuyenXe']}</td>
                                                <td>{$row['TenNhaXe']}</td>
                                                <td>{$row['DiemDon']}</td>
                                                <td>{$row['DiemTra']}</td>
                                                <td>" . formatDay($row['Ngay']) . "</td>
                                                
                                                <td>
                                                    <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='{$row['MaChuyenXe']}'><i class='fas fa-edit'></i> Sửa</button>
                                                    <button class='btn btn-danger btn-sm btnDelete' data-id='{$row['MaChuyenXe']}'><i class='fas fa-trash-alt'></i> Xóa</button>
                                                </td>
                                            </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
                            }
                            $stmt->close();
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="../js/route.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>