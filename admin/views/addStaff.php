<?php
include '../module/adminHandler.php';
include 'layout/header.php';
include 'layout/slidebar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];

    if (addStaff($name, $email, $password, $usertype)) {
        $success_message = "Thêm nhân viên thành công!";
        
    } else {
        $error_message = "Có lỗi xảy ra. Vui lòng thử lại.";
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

    <form method="POST" >
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
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
