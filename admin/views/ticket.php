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
    <title>Quản lý vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Danh sách vé</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý vé</li>
                </ol>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm">
                <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>
            <!--  -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nhập thông tin vé</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/ticket_p.php" method="POST">
                                <div class="mb-3">
                                    <label for="id_trip" class="form-label">Mã Chuyến</label>
                                    <select class="form-select" id="id_trip" name="id_trip" required>
                                        <option value="" disabled selected>Chọn mã chuyến</option>
                                        <?php
                                        $sql = "SELECT id_trip FROM trip";
                                        $result = $conn->query($sql);
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['id_trip'], ENT_QUOTES, 'UTF-8') . '">'
                                                    . htmlspecialchars($row['id_trip'], ENT_QUOTES, 'UTF-8') . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>Không có chuyến xe</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên khách hàng" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="mb-3">
                                    <label for="number_seat" class="form-label">Số ghế</label>
                                    <input type="number" class="form-control" id="number_seat" name="number_seat" min="1" placeholder="Nhập số ghế" required>
                                </div>
                                <div class="mb-3">
                                    <label for="total_price" class="form-label">Tổng tiền</label>
                                    <input type="number" class="form-control" id="total_price" name="total_price" placeholder="Nhập giá" required>
                                </div>
                                <div class="mb-3">
                                    <label for="method" class="form-label">Phương thức</label>
                                    <select class="form-select" id="method" name="method" required>
                                        <option value="" disabled selected>Chọn phương thức</option>
                                        <option value="0">Tiền mặt</option>
                                        <option value="1">Thẻ tín dụng</option>
                                        <option value="2">Chuyển khoản</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="date" class="form-label">Ngày</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Tình trạng</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="" disabled selected>Chọn tình trạng</option>
                                        <option value="0">Đã thanh toán</option>
                                        <option value="1">Chưa thanh toán</option>
                                        <option value="2">Đã hủy</option>
                                        <option value="3">Đã đi</option>
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
            <!--  -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông tin vé</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../module/ticket_p.php" method="POST">
                                <input type="hidden" name="id_ticket" id="edit_Id_ticket">
                                <div class="mb-3">
                                    <label for="edit_id_ticket" class="form-label">Mã Chuyến</label>
                                    <select class="form-select" id="edit_id_trip" name="id_trip" required>
                                        <option value="" disabled>Chọn mã chuyến</option>
                                        <?php
                                        $sql = "SELECT id_trip FROM trip";
                                        $result = $conn->query($sql);
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['id_trip'], ENT_QUOTES, 'UTF-8') . '">'
                                                    . htmlspecialchars($row['id_trip'], ENT_QUOTES, 'UTF-8') . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>Không có chuyến xe</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Tên khách hàng</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" placeholder="Nhập tên khách hàng" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="edit_phone" name="phone" placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_number_seat" class="form-label">Số ghế</label>
                                    <input type="number" class="form-control" id="edit_number_seat" name="number_seat" min="1" placeholder="Nhập số ghế" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_total_price" class="form-label">Tổng tiền</label>
                                    <input type="number" class="form-control" id="edit_total_price" name="total_price" placeholder="Nhập giá" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_method" class="form-label">Phương thức</label>
                                    <select class="form-select" id="edit_method" name="method" required>
                                        <option value="" disabled>Chọn phương thức</option>
                                        <option value="0">Tiền mặt</option>
                                        <option value="1">Thẻ tín dụng</option>
                                        <option value="2">Chuyển khoản</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_date" class="form-label">Ngày</label>
                                    <input type="date" class="form-control" id="edit_date" name="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_status" class="form-label">Tình trạng</label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="" disabled>Chọn tình trạng</option>
                                        <option value="0">Chưa thanh toán</option>
                                        <option value="1">Đã thanh toán</option>
                                        <option value="2">Đã hủy</option>
                                        <option value="3">Đã đi</option>
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
                            <h5 class="modal-title" id="deleteModalLabel">Hủy vé</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có chắc chắn muốn hủy vé này không?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="../module/ticket_p.php" method="POST">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id_ticket" id="deleteId_ticket">
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
                    <?php
                    $search_keyword = $_POST['search_keyword'] ?? '';
                    $sql = "SELECT id_ticket, id_trip, name, phone, number_seat, total_price, method, date, status FROM ticket";

                    if ($search_keyword) {
                        $sql .= " WHERE id_ticket LIKE ? OR phone LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $like_keyword = "%" . $search_keyword . "%";
                        $stmt->bind_param("ss", $like_keyword, $like_keyword);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    } else {
                        $result = $conn->query($sql);
                    }
                    ?>

                    <thead class="table-dark">
                        <tr>
                            <th>Mã Vé</th>
                            <th>Mã Chuyến</th>
                            <th>Tên Khách Hàng</th>
                            <th>Số điện thoại</th>
                            <th>Số ghế</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức</th>
                            <th>Ngày</th>
                            <th>Tình trạng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody id="dataTable">
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                            $methodValue = $row['method'];
                            $statusValue = $row['status'];
                            $methodText = isset($method[$methodValue]) ? $method[$methodValue] : 'Chưa xác định';
                            $statusText = isset($status[$statusValue]) ? $status[$statusValue] : 'Chưa xác định';
                            $total_price = number_format($row['total_price'], 0, ',', '.') . ' đ';

                                echo "<tr>
                        <td>{$row['id_ticket']}</td>
                        <td>{$row['id_trip']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['number_seat']}</td>
                        <td>{$total_price}</td>
                        <td>{$methodText}</td>
                        <td>" . formatDay($row['date']) . "</td>
                        <td>{$statusText}</td>
                        <td>
                            <button class='btn btn-warning btn-sm me-1 btnEdit'
                                data-id='" . $row['id_ticket'] . "'
                                data-id_trip='" . $row['id_trip'] . "'
                                data-name='" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "'
                                data-phone='" . htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8') . "'
                                data-number_seat='" . $row['number_seat'] . "'
                                data-total_price='" . $row['total_price'] . "'
                                data-method='" . $row['method'] . "'
                                data-date='" . $row['date'] . "'
                                data-status='" . $row['status'] . "'>
                                <i class='fas fa-edit'></i> Sửa </button>
                            <button class='btn btn-danger btn-sm btnDelete' data-id='" . $row['id_ticket'] . "'><i class='fas fa-trash-alt'></i> Xóa</button>
                        </td>
                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>Không có dữ liệu</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script src="../js/ticket.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>