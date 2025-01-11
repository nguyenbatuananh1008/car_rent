<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhà Xe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Danh sách Nhà Xe</h3>
                <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item active">Quản lý nhà xe</li>
            </div>

            <!--  -->
            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm theo tên nhà xe">
                <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>

            <!-- -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập thông tin nhà xe</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/C_house_P.php" method="POST">
                                <div class="mb-3">
                                    <label for="name_c_house" class="form-label">Tên nhà xe</label>
                                    <input type="text" class="form-control" id="name_c_house" name="name_c_house" required>
                                </div>
                                <div class="mb-3">
                                    <label for="Address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" id="Address" name="address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="btn btn-primary">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!---->
            <table class="table table-bordered table-hover">
                <?php
                $search_keyword = $_POST['search_keyword'] ?? '';
                $sql = "SELECT id_c_house, name_c_house, address, phone, email FROM car_house";
                if ($search_keyword) {
                    $sql .= " WHERE name_c_house LIKE ? OR address LIKE ? OR phone LIKE ? OR email LIKE ?";
                    $stmt = $conn->prepare($sql);
                    $like_keyword = "%" . $search_keyword . "%";
                    $stmt->bind_param("ssss", $like_keyword, $like_keyword, $like_keyword, $like_keyword);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $result = $conn->query($sql);
                }
                ?>
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên nhà xe</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="dataTable">
                    <?php
                    if ($result->num_rows > 0) {
                        $stt = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . $stt++ . "</td>
                                <td>" . $row['name_c_house'] . "</td>
                                <td>" . $row['address'] . "</td>
                                <td>" . $row['phone'] . "</td>
                                <td>" . $row['email'] . "</td>
                                <td>
                                    <button class='btn btn-warning btn-sm me-1 btnEdit' data-id='".$row['id_c_house']."' data-name='".$row['name_c_house']."' data-address='".$row['address']."' data-phone='".$row['phone']."' data-email='".$row['email']."'><i class='fas fa-edit'></i> Sửa</button>
                                    <button class='btn btn-danger btn-sm btnDelete' data-id='".$row['id_c_house']."'><i class='fas fa-trash-alt'></i> Xóa</button>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        

    <!-- -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Sửa thông tin nhà xe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../module/C_house_P.php" method="POST">
                        <input type="hidden" name="id_c_house" id="editId_c_house">
                        <div class="mb-3">
                            <label for="edit_name_c_house" class="form-label">Tên nhà xe</label>
                            <input type="text" class="form-control" id="edit_name_c_house" name="name_c_house" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="edit_address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="edit_phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <input type="hidden" name="action" value="edit">
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
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
                    <h5 class="modal-title" id="deleteModalLabel">Xóa nhà xe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa nhà xe này không?</p>
                </div>
                <div class="modal-footer">
                    <form action="../module/C_house_P.php" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_c_house" id="deleteId_c_house">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <script>
        document.querySelectorAll('.btnEdit').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = e.target.closest('button').getAttribute('data-id');
                const name = e.target.closest('button').getAttribute('data-name');
                const address = e.target.closest('button').getAttribute('data-address');
                const phone = e.target.closest('button').getAttribute('data-phone');
                const email = e.target.closest('button').getAttribute('data-email');
                
                document.getElementById('editId_c_house').value = id;
                document.getElementById('edit_name_c_house').value = name;
                document.getElementById('edit_address').value = address;
                document.getElementById('edit_phone').value = phone;
                document.getElementById('edit_email').value = email;

                new bootstrap.Modal(document.getElementById('editModal')).show();
            });
        });

      
        document.querySelectorAll('.btnDelete').forEach(button => {
            button.addEventListener('click', (e) => {
                const id = e.target.closest('button').getAttribute('data-id');
                document.getElementById('deleteId_c_house').value = id;
                new bootstrap.Modal(document.getElementById('deleteModal')).show();
            });
        });

            document.getElementById('btnSearch').addEventListener('click', function() {
                var searchKeyword = document.getElementById('searchKeyword').value;

                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '';

                var inputAction = document.createElement('input');
                inputAction.type = 'hidden';
                inputAction.name = 'search_keyword';
                inputAction.value = searchKeyword;
                form.appendChild(inputAction);

                document.body.appendChild(form);
                form.submit();
            });
        </script>
</body>
</html>
<?php include 'footer.php'; ?>

