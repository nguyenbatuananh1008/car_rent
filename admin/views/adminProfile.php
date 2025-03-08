<?php
include '../module/adminHandler.php';
include 'navbar.php';
include 'slidebar.php';
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý Tài Khoản Cá Nhân</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
  <div id="layoutSidenav_content">
    <div class="content-wrapper">
      <div class="container py-4">
        <h1 class="mb-4">Quản lý Tài khoản Cá nhân</h1>
        
        <?php if (isset($success_message)): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success_message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php elseif (isset($error_message)): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error_message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <div class="row">
          <!-- Form cập nhật thông tin tài khoản -->
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Cập nhật Thông tin Tài khoản</h5>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="name" class="form-label">Tên</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($admin['name']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="image" class="form-label">Ảnh</label>
                    <input type="file" name="image" class="form-control">
                    <?php if (!empty($admin['image'])): ?>
                      <div class="mt-2">
                        <img src="../uploads/<?= htmlspecialchars($admin['image']) ?>" alt="Ảnh admin" class="img-thumbnail" style="width: 100px; height: 100px;">
                      </div>
                    <?php else: ?>
                      <p class="mt-2">Chưa có ảnh</p>
                    <?php endif; ?>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Loại Tài khoản</label>
                    <input type="text" class="form-control" value="<?= $admin['usertype'] == 1 ? 'Admin' : 'Nhân viên' ?>" readonly>
                  </div>
                  <button type="submit" name="update_name" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Cập nhật thông tin
                  </button>
                </form>
              </div>
            </div>
          </div>

          <!-- Form cập nhật mật khẩu -->
          <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header bg-warning text-dark">
                <h5 class="card-title mb-0">Đổi Mật khẩu</h5>
              </div>
              <div class="card-body">
                <form method="POST">
                  <div class="mb-3">
                    <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label for="new_password" class="form-label">Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                  </div>
                  <button type="submit" name="update_password" class="btn btn-warning">
                    <i class="fas fa-key me-1"></i> Cập nhật mật khẩu
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div> <!-- end row -->

      </div> <!-- end container -->
    </div> <!-- end content-wrapper -->
  </div> <!-- end layoutSidenav_content -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
