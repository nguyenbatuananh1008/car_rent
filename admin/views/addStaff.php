<?php
include '../module/adminHandler.php';
include 'layout/header.php';
include 'layout/slidebar.php';
include '../module/auth.php';
checkAccess(0); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

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
            if (addStaff($name, $email, $password, $usertype, $imageName)) {
                $success_message = "Thêm nhân viên thành công!";
            } else {
                $error_message = "Có lỗi xảy ra. Vui lòng thử lại.";
            }
        } else {
            $error_message = "Không thể tải ảnh lên. Vui lòng thử lại.";
        }
    } else {
        $error_message = "Vui lòng chọn một ảnh hợp lệ.";
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
    <h1>Thêm nhân viên</h1>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" >
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="label">Ảnh</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="usertype">Loại tài khoản</label>
            <select id="usertype" name="usertype" class="form-control" required>
                <option value="0">Nhân viên</option>
                <option value="1">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="staffList.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include 'layout/footer.php'; ?>
