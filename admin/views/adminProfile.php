<?php
session_start();
include '../module/adminHandler.php';
include '../views/layout/header.php';
include '../views/layout/slidebar.php';
include '../module/auth.php';
checkAccess(0); 

// Lấy thông tin admin từ session
if (!isset($_SESSION['id_admin'])) {
    header("Location: login.php"); // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    exit();
}

$id_admin = $_SESSION['id_admin']; // Lấy ID admin từ session
$admin = getAdminInfo($id_admin); // Lấy thông tin admin từ database

// Xử lý khi admin cập nhật thông tin và ảnh
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_name'])) {
    $new_name = $_POST['name'];
    $imageName = $admin['image']; // Giữ ảnh cũ mặc định

    // Kiểm tra nếu có ảnh mới được upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = '../uploads/' . $imageName;

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir('../uploads/')) {
            mkdir('../uploads/', 0777, true);
        }

        // Di chuyển file vào thư mục uploads
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            if (!empty($admin['image']) && file_exists('../uploads/' . $admin['image'])) {
                unlink('../uploads/' . $admin['image']); // Xóa ảnh cũ nếu tồn tại
            }
        } else {
            $error_message = "Không thể tải ảnh lên. Vui lòng thử lại.";
        }
    }

    if (updateAdminInfo($id_admin, $new_name, null, $imageName)) {
        $success_message = "Cập nhật thông tin thành công!";
        $admin = getAdminInfo($id_admin); // Lấy lại thông tin mới
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.";
    }
}

// Xử lý khi admin cập nhật mật khẩu
if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra mật khẩu hiện tại
    if ($current_password === $admin['password']) { // So sánh mật khẩu (không mã hóa)
        if ($new_password === $confirm_password) {
            if (updateAdminInfo($id_admin, null, $new_password, null)) {
                $success_message = "Cập nhật mật khẩu thành công!";
            } else {
                $error_message = "Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại.";
            }
        } else {
            $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
        }
    } else {
        $error_message = "Mật khẩu hiện tại không chính xác!";
    }
}
?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"></div>
<div class="container">
    <h1>Quản lý tài khoản cá nhân </h1>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <!-- Form cập nhật tên và ảnh -->
    <form method="POST" enctype="multipart/form-data">
        <h3>Thông tin tài khoản</h3>
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($admin['name']) ?>" required>
        </div>
        <div class="form-group">
            <label for="label">Ảnh</label>
            <input type="file" name="image" class="form-control">
            <?php if (!empty($admin['image'])): ?>
                <img src="../uploads/<?= htmlspecialchars($admin['image']) ?>" alt="Ảnh admin" style="width: 100px; height: 100px; margin-top: 10px; border-radius: 10%;">
            <?php else: ?>
                <p>Chưa có ảnh</p>
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>Loại tài khoản</label>
            <input type="text" class="form-control" value="<?= $admin['usertype'] == 1 ? 'Admin' : 'Nhân viên' ?>" readonly>
        </div>
        <button type="submit" name="update_name" class="btn btn-primary">Cập nhật thông tin</button>
    </form>

    <hr>

    <!-- Form cập nhật mật khẩu -->
    <form method="POST">
        <h3>Đổi mật khẩu</h3>
        <div class="form-group">
            <label for="current_password">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_password">Mật khẩu mới</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu mới</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" name="update_password" class="btn btn-primary">Cập nhật mật khẩu</button>
    </form>
</div>
</div>
</div>
</div>
</div>
</div>

<?php include '../views/layout/footer.php'; ?>
