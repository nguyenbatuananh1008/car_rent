<?php
include '../module/adminHandler.php';
include 'layout/header.php';
include 'layout/slidebar.php';
include '../module/auth.php';
checkAccess(0); 
$id = $_GET['id'];
$staff = getStaffById($id);

// Xử lý khi cập nhật thông tin nhân viên (bao gồm ảnh)
if (isset($_POST['update_name'])) {
    $new_name = $_POST['name'];
    $usertype = $staff['usertype']; // Giữ nguyên loại tài khoản

    // Xử lý ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $imagePath = '../uploads/' . $imageName;

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir('../uploads/')) {
            mkdir('../uploads/', 0777, true);
        }

        // Di chuyển file vào thư mục uploads
        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
            $staff['image'] = $imageName; // Cập nhật tên file ảnh trong dữ liệu nhân viên
        } else {
            $error_message = "Không thể tải ảnh lên. Vui lòng thử lại.";
        }
    }

    // Cập nhật thông tin nhân viên
    if (updateStaff($id, $new_name, $staff['email'], $staff['password'], $usertype, $staff['image'])) {
        $success_message = "Cập nhật thông tin nhân viên thành công!";
        $staff = getStaffById($id); // Lấy lại thông tin mới sau khi cập nhật
    } else {
        $error_message = "Có lỗi xảy ra khi cập nhật thông tin. Vui lòng thử lại.";
    }
}

// Xử lý khi cập nhật mật khẩu
if (isset($_POST['update_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        if (updateStaff($id, $staff['name'], $staff['email'], $new_password, $staff['usertype'], $staff['image'])) {
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
                    <!-- Form cập nhật tên và ảnh -->
                    <form method="POST" enctype="multipart/form-data">
                        <h3>Thông tin nhân viên</h3>
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($staff['name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="label">Ảnh</label>
                            <input type="file" name="image" class="form-control">
                            <?php if (!empty($staff['image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($staff['image']) ?>" alt="Ảnh nhân viên" style="width: 100px; height: 100px; margin-top: 10px; border-radius: 10%;">
                            <?php else: ?>
                                <p>Chưa có ảnh</p>
                            <?php endif; ?>
                        </div>
                        <br>
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
