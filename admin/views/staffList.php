<?php
session_start();
include '../module/adminHandler.php';
include_once 'slidebar.php';
include_once 'navbar.php';
include '../module/auth.php';
checkAccess(1); 

// Kiểm tra nếu có từ khóa tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : null;

// Lấy danh sách nhân viên (có tìm kiếm nếu có)
$staffList = getStaffList($search);

// Xử lý xóa nhân viên
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    if (deleteUser($id)) {
        $success_message = "Xóa nhân viên thành công!";
        $staffList = getStaffList($search); // Cập nhật lại danh sách
    } else {
        $error_message = "Không thể xóa. Nhân viên không tồn tại hoặc không hợp lệ.";
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khách Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="layoutSidenav_content">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lý nhân viên</h1>
                        </div>
                        <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-12">
                        <form class="input-group" method="GET" action="">
                            
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control" 
                                placeholder="Tìm kiếm nhân viên..."
                                value="<?= htmlspecialchars($search) ?>" />
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> <!-- Icon FontAwesome -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success"><?= $success_message ?></div>
                    <?php elseif (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= $error_message ?></div>
                    <?php endif; ?>
                    
                    <a href="addStaff.php" class="btn btn-primary mb-3">Thêm nhân viên</a>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã nhân viên</th>
                                <th>Họ tên</th>
                                <th>Hình ảnh</th>
                                <th>Email</th>
                                <th>Loại tài khoản</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($staffList)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không tìm thấy nhân viên phù hợp.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($staffList as $staff): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($staff['id_admin']) ?></td>
                                        <td><?= htmlspecialchars($staff['name']) ?></td>
                                        <td>
                                            <?php if (!empty($staff['image'])): ?>
                                                <img src="../uploads/<?= htmlspecialchars($staff['image']) ?>" alt="Hình ảnh nhân viên" style="width: 50px; height: 50px; border-radius: 50%;">
                                            <?php else: ?>
                                                Không có ảnh
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($staff['email']) ?></td>
                                        <td><?= $staff['usertype'] == 1 ? 'Admin' : 'Nhân viên' ?></td>
                                        <td>
                                            <a href="editStaff.php?id=<?= $staff['id_admin'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                                            <a href="?delete_id=<?= $staff['id_admin'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>




