<?php
require_once '../module/Admin.php'; // Đảm bảo đường dẫn đúng
session_start();

$message = ""; // Biến lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Kiểm tra trường hợp để trống
    if (empty($email) || empty($password)) {
        $message = "Email và mật khẩu không được để trống!";
    } else {
        try {
            $adminHandler = new Admin(); // Khởi tạo đối tượng Admin
            $result = $adminHandler->login($email, $password); // Gọi hàm login

            if ($result) {
                // Lưu thông tin vào session
                $_SESSION['id_admin'] = $result['id_admin'];
                $_SESSION['name'] = $result['name'];
                $_SESSION['usertype'] = $result['usertype'];

                // Chuyển hướng đến index.php
                header("Location: index.php");
                exit();
            } else {
                $message = "Email hoặc mật khẩu không đúng!";
            }
        } catch (Exception $e) {
            $message = "Lỗi hệ thống: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Admin</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-image">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-8 col-sm-10">
                            <div class="card shadow-lg border-0 rounded-4 mt-5 login-card">
                                <div class="card-header text-white text-center py-4">
                                    <h3 class="fw-bold">Đăng Nhập</h3>
                                </div>
                                <div class="card-body p-4">
                                    <!-- Hiển thị thông báo lỗi -->
                                    <?php if (!empty($message)): ?>
                                        <div class="alert alert-danger text-center">
                                            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Form đăng nhập -->
                                    <form method="POST" action="">
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control rounded-3"
                                                id="inputEmail"
                                                name="email"
                                                type="email"
                                                placeholder="name@example.com"
                                                value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                                                required />
                                            <label for="inputEmail">Địa chỉ Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input
                                                class="form-control rounded-3"
                                                id="inputPassword"
                                                name="password"
                                                type="password"
                                                placeholder="Mật khẩu"
                                                required />
                                            <label for="inputPassword">Mật khẩu</label>
                                        </div>
                                        <div class="d-grid mt-4">
                                            <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow">Đăng Nhập</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <small>Chưa có tài khoản? <a href="#">Đăng ký ngay</a></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <footer class="py-4 bg-light mt-auto text-center">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    <div>
                        <a href="#">Chính sách bảo mật</a> &middot; <a href="#">Điều khoản sử dụng</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
</body>

</html>