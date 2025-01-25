<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php';
$db = new Database();
$conn = $db->connectBee();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Xe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Danh sách xe</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý xe</li>
            </div>

            <!--  -->
            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm theo tên xe">
                <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm
                </button>
            </div>

            <!-- -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập thông tin xe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/car_p.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="c_name" class="form-label">Hãng xe</label>
                                    <input type="text" class="form-control" id="c_name" name="c_name" list="car_names" required>
                                    <datalist id="car_names">
                                        <?php
                                        
                                        $sql = "SELECT DISTINCT c_name FROM car";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['c_name']) . '">';
                                            }
                                        }
                                        ?>
                                    </datalist>
                                </div>
                                <div class="mb-3">
                                    <label for="c_type" class="form-label">Loại xe</label>
                                    <input type="text" class="form-control" id="c_type" name="c_type" required>
                                </div>
                                <div class="mb-3">
                                    <label for="c_color" class="form-label">Màu xe</label>
                                    <input type="text" class="form-control" id="c_color" name="c_color" required>
                                </div>
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Số chỗ</label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="c_plate" class="form-label">Biển số</label>
                                    <input type="text" class="form-control" id="c_plate" name="c_plate" required>
                                </div>
                                <label for="name_c_house" class="form-label">Các nhà xe</label>
                                <select class="form-select" id="id_c_house" name="id_c_house" required>
                                    <?php
                                    $sql = "SELECT id_c_house, name_c_house FROM car_house";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($row['id_c_house'], ENT_QUOTES, 'UTF-8') . '">'
                                                . htmlspecialchars($row['name_c_house'], ENT_QUOTES, 'UTF-8') . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">Không có nhà xe</option>';
                                    }
                                    ?>
                                </select>
                                <br>
                                <div class="mb-3">
                                    <label class="form-label" for="img">Hình ảnh</label>
                                    <input type="file" name="img" class="form-control" id="img" required />
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
                <div>
                    <table class="table table-bordered table-hover">
                        <?php
                        $search_keyword = $_POST['search_keyword'] ?? '';
                        $sql = "SELECT car.id_car, car.c_name, car.c_type, car.c_color, car.capacity, car.c_plate, car.img, car_house.name_c_house 
                        FROM car 
                        JOIN car_house ON car.id_c_house = car_house.id_c_house";

                        if (!empty($search_keyword)) {
                            $sql .= " WHERE car.c_name LIKE ? OR car.c_plate LIKE ? OR car.capacity LIKE ? OR car_house.name_c_house LIKE ?";
                        }

                        $stmt = $conn->prepare($sql);
                        if ($stmt) {
                            if (!empty($search_keyword)) {
                                $like_keyword = "%" . $search_keyword . "%";
                                $stmt->bind_param("ssss", $like_keyword, $like_keyword, $like_keyword, $like_keyword);
                            }
                            $stmt->execute();
                            $result = $stmt->get_result();
                        } else {
                            echo "<tr><td colspan='7' class='text-danger'>Lỗi chuẩn bị truy vấn: " . $conn->error . "</td></tr>";
                            $result = null;
                        }
                        ?>
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Hãng xe</th>
                                <th>Loại xe</th>
                                <th>Màu xe</th>
                                <th>Sức chứa</th>
                                <th>Biển số xe</th>
                                <th>Nhà xe</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                $stt = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                    <td>" . $stt++ . "</td>
                    <td>" . htmlspecialchars($row['c_name']) . "</td>
                    <td>" . htmlspecialchars($row['c_type']) . "</td>
                    <td>" . htmlspecialchars($row['c_color']) . "</td>
                    <td>" . htmlspecialchars($row['capacity']) . "</td>
                    <td>" . htmlspecialchars($row['c_plate']) . "</td>
                    <td>" . htmlspecialchars($row['name_c_house']) . "</td>
                    <td><img src='../uploads/" . htmlspecialchars($row['img']) . "' width='100' alt='Hình ảnh'></td>
                    <td>
                        <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='" . $row['id_car'] . "' 
                                data-name='" . htmlspecialchars($row['c_name']) . "' 
                                data-type='" . htmlspecialchars($row['c_type']) . "' 
                                data-color='" . htmlspecialchars($row['c_color']) . "' 
                                data-capacity='" . htmlspecialchars($row['capacity']) . "' 
                                data-plate='" . htmlspecialchars($row['c_plate']) . "' 
                                data-name2='" . htmlspecialchars($row['name_c_house']) . "' 
                                data-img='" . htmlspecialchars($row['img']) . "'>
                            <i class='fas fa-edit'></i> Sửa
                        </button>
                        <button class='btn btn-danger btn-sm btnDelete' data-id='" . $row['id_car'] . "'>
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

            <!--  -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin xe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../module/car_p.php" method="POST" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" id="edit_id_car" name="id_car">
                                <div class="mb-3">
                                    <label for="edit_c_name" class="form-label">Hãng xe</label>
                                    <input type="text" class="form-control" id="edit_c_name" name="c_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_c_type" class="form-label">Loại xe</label>
                                    <input type="text" class="form-control" id="edit_c_type" name="c_type" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_c_color" class="form-label">Màu xe</label>
                                    <input type="text" class="form-control" id="edit_c_color" name="c_color" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_capacity" class="form-label">Số chỗ</label>
                                    <input type="number" class="form-control" id="edit_capacity" name="capacity" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_c_plate" class="form-label">Biển số</label>
                                    <input type="text" class="form-control" id="edit_c_plate" name="c_plate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_id_c_house" class="form-label">Nhà xe</label>
                                    <select class="form-select" id="edit_id_c_house" name="id_c_house" required>
                                        <?php
                                        $sql = "SELECT id_c_house, name_c_house FROM car_house";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['id_c_house'], ENT_QUOTES, 'UTF-8') . '">'
                                                    . htmlspecialchars($row['name_c_house'], ENT_QUOTES, 'UTF-8') . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Không có nhà xe</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="edit_img">Hình ảnh</label>
                                    <input type="file" name="img" class="form-control" id="edit_img">
                                    <div class="mt-2">
                                        <img id="edit_preview_img" src="#" width="100" alt="Hình hiện tại">
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="edit">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa xe này không?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="../module/car_p.php" method="POST">
                            <input type="hidden" id="delete_id_car" name="id_car">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger">Xóa</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/car.js"></script>

</body>

</html>
<?php include_once 'footer.php'; ?>