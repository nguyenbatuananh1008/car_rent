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
    <title>Quản lý thành phố</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Danh sách tỉnh / thành phố</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý tỉnh / Thành phố</li>
                </ol>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm theo tên nhà xe">
                <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>

            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập tỉnh / thành phố </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/City_p.php" method="POST">
                                <div class="mb-3">
                                    <label for="city_name" class="form-label">Tên tỉnh / thành phố</label>
                                    <input type="text" class="form-control" id="city_name" name="city_name" required>
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
                            <h5 class="modal-title" id="editModalLabel">Sửa tỉnh / thành phố</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/city_p.php" method="POST">
                                <input type="hidden" name="id_city" id="editId_city">
                                <div class="mb-3">
                                    <label for="edit_city_name" class="form-label">Tên tỉnh / thành phố </label>
                                    <input type="text" class="form-control" id="edit_city_name" name="city_name" required>
                                </div>
                                <input type="hidden" name="action" value="edit">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa thành phố</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa thành phố này không?</p>
                </div>
                <div class="modal-footer">
                    <form action="../module/city_p.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_city" id="deleteId_city">
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
                            <th>Tên thành phố</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                    <?php
                    $search_keyword = $_POST['search_keyword'] ?? '';
                    $sql = "SELECT id_city, city_name FROM city";

                    if ($search_keyword) {
                        $sql .= " WHERE city_name LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $like_keyword = "%" . $search_keyword . "%";
                        $stmt->bind_param("s", $like_keyword);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $result = $conn->query($sql);
                    }

                    if ($result->num_rows > 0) {
                        $stt = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $stt++ . '</td>';
                            echo '<td>' . htmlspecialchars($row['city_name'], ENT_QUOTES) . '</td>';
                            echo '<td>
                                    <button class="btn btn-warning btnEdit" data-id="' . $row['id_city'] . '" data-city_name="' . htmlspecialchars($row['city_name'], ENT_QUOTES) . '">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger btnDelete" data-id="' . $row['id_city'] . '">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
                    }

                    $conn->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>


<script src="../js/city.js"></script>
</html>
<? include_once 'footer.php'; ?>