<?php
include '../module/adminHandler.php';
include 'layout/header.php';
include 'layout/slidebar.php';
include '../module/auth.php';
checkAccess(0); 
$id = $_GET['id'];
$staff = getStaffById($id);

// Xử lý khi cập nhật tên và loại tài khoản
if (isset($_POST['update_name'])) {
    $new_name = $_POST['name'];
    $usertype = $staff['usertype']; // Giữ nguyên loại tài khoản
    if (updateStaff($id, $new_name, $staff['email'], $staff['password'], $usertype)) {
        $success_message = "Cập nhật tên thành công!";
        $staff = getStaffById($id); // Lấy lại thông tin mới
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật tên. Vui lòng thử lại.";
    }
}

// Xử lý khi cập nhật mật khẩu
if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        if (updateStaff($id, $staff['name'], $staff['email'], $new_password, $staff['usertype'])) {
            $success_message = "Cập nhật mật khẩu thành công!";
        } else {
            $error_message = "Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại.";
        }
    } else {
        $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
    }
}
?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>Sửa thông tin Nhân viên</h1>
                    <?php if (isset($success_message)): ?>
                        <div class="alert alert-success"><?= $success_message ?></div>
                    <?php elseif (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= $error_message ?></div>
                    <?php endif; ?>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <!-- Form cập nhật tên -->
                    <form method="POST">
                        <h3>Thông tin nhân viên</h3>
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($staff['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($staff['email']) ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Loại tài khoản</label>
                            <input type="text" class="form-control" value="<?= $staff['usertype'] == 1 ? 'Admin' : 'Nhân viên' ?>" readonly>
                        </div>
                        <button type="submit" name="update_name" class="btn btn-primary">Cập nhật thông tin</button>
                    </form>

                    <hr>

                    <!-- Form cập nhật mật khẩu -->
                    <form method="POST">
                        <h3>Đổi mật khẩu</h3>
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
            </section>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
