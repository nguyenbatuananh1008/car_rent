<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php'; ?>
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
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm theo tên nhà xe">
                <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm 
                </button>
            </div>

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
                                    <label for="c_name" class="form-label">Tên xe</label>
                                    <input type="text" class="form-control" id="c_name" name="c_name" required>
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
                                <div class="mb-3">
                                    <label class="form-label" for="img"></label>
                                    <input type="file" name="img" class="form-control" id="img" required />
                                </div>
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="btn btn-primary">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

                <div>
                <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên xe</th>
                    <th>Sức chứa</th>
                    <th>Biển số xe</th>
                    <th>Nhà xe</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT car.id_car, car.c_name, car.capacity, car.c_plate, car.img, car_house.name_c_house FROM car JOIN car_house ON car.id_c_house = car_house.id_c_house";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $stt = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $stt++ . "</td>
                            <td>" . $row['c_name'] . "</td>
                            <td>" . $row['capacity'] . "</td>
                            <td>" . $row['c_plate'] . "</td>
                            <td>" . $row['name_c_house'] . "</td>
                            <td><img src='../uploads/" . $row['img'] . "' width='100'></td>
                            <td>
                                <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='" . $row['id_car'] . "' data-name='" . $row['c_name'] . "' data-capacity='" . $row['capacity'] . "' data-plate='" . $row['c_plate'] . "' data-name2='" . $row['name_c_house'] . "' data-img='" . $row['img'] . "'><i class='fas fa-edit'></i> Sửa</button>
                                <button class='btn btn-danger btn-sm btnDelete' data-id='" . $row['id_car'] . "'><i class='fas fa-trash-alt'></i> Xóa</button>
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
                                        <label for="edit_c_name" class="form-label">Tên xe</label>
                                        <input type="text" class="form-control" id="edit_c_name" name="c_name" required>
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

            <script>
                 
            document.getElementById('btnSearch').addEventListener('click', function() {
                var searchKeyword = document.getElementById('searchKeyword').value.toLowerCase();
                var rows = document.querySelectorAll('#carList tr');
                rows.forEach(row => {
                    var carName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (carName.includes(searchKeyword)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

                document.querySelectorAll('.btnEdit').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        const name = button.getAttribute('data-name');
                        const capacity = button.getAttribute('data-capacity');
                        const plate = button.getAttribute('data-plate');
                        const id_c_house = button.getAttribute('data-name2');
                        const img = button.getAttribute('data-img');

                        document.getElementById('edit_id_car').value = id;
                        document.getElementById('edit_c_name').value = name;
                        document.getElementById('edit_capacity').value = capacity;
                        document.getElementById('edit_c_plate').value = plate;
                        document.getElementById('edit_id_c_house').value = id_c_house;
                        document.getElementById('edit_preview_img').src = '../img' + img;

                        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                        editModal.show();
                    });
                });

                document.querySelectorAll('.btnDelete').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        document.getElementById('delete_id_car').value = id;

                        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                        deleteModal.show();
                    });
                });

                
            </script>

</body>
</html>
<?php include_once 'footer.php'; ?>