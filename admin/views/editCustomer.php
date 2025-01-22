<?php
include '../module/customerHandler.php';
include '../module/auth.php';
checkAccess(0); 
// Lấy thông tin khách hàng cần sửa
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $customer = getCustomerById($id_user);

    if (!$customer) {
        die('Không tìm thấy thông tin khách hàng.');
    }
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (updateCustomer($id_user, $name, $email)) {
        // Thêm thông báo sửa thành công
        $success_message = "Khách hàng đã được cập nhật thành công!";
    } else {
        $error_message = "Cập nhật thất bại, vui lòng thử lại!";
    }
}
?>

<?php include 'navbar.php'; ?>

<?php include 'slidebar.php'; ?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Chỉnh sửa khách hàng</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Hiển thị thông báo -->
                                    <?php if (isset($success_message)): ?>
                                        <div class="alert alert-success"><?= $success_message ?></div>
                                    <?php elseif (isset($error_message)): ?>
                                        <div class="alert alert-danger"><?= $error_message ?></div>
                                    <?php endif; ?>
                                    
                                    <form method="POST">
                                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($customer['id_user']) ?>">
                                        <div class="form-group">
                                            <label for="name">Họ tên</label>
                                            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($customer['name']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($customer['email']) ?>" required>
                                        </div>
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                                            <a href="customerList.php" class="btn btn-secondary">Hủy</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
