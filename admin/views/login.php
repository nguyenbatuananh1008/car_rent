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
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Đăng Nhập</h3></div>
                                    <div class="card-body">
                                        <!-- Hiển thị thông báo lỗi -->
                                        <?php if (!empty($message)): ?>
                                            <div class="alert alert-danger">
                                                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Form đăng nhập -->
                                        <form method="POST" action="">
                                            <div class="form-floating mb-3">
                                                <input 
                                                    class="form-control" 
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
                                                    class="form-control" 
                                                    id="inputPassword" 
                                                    name="password" 
                                                    type="password" 
                                                    placeholder="Mật khẩu" 
                                                    required />
                                                <label for="inputPassword">Mật khẩu</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Chính sách bảo mật</a>
                                &middot;
                                <a href="#">Điều khoản sử dụng</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
    </body>
</html>
