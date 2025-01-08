<?php

require_once '../module/Admin.php';

$message = ""; // Biến lưu thông báo lỗi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Lấy email từ form
    $password = $_POST['password']; // Lấy mật khẩu từ form

    $admin = new Admin();
    $result = $admin->login($email, $password); // Gọi hàm login để kiểm tra thông tin đăng nhập

    if ($result) {
        session_start();
        $_SESSION['admin'] = $result; // Lưu thông tin admin vào session
        header("Location:index.php"); // Chuyển hướng đến trang index
        exit();
    } else {
        $message = "Email hoặc mật khẩu không đúng!"; // Thông báo lỗi
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
                                                <?= $message; ?>
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
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" />
                                                <label class="form-check-label" for="inputRememberPassword">Nhớ mật khẩu</label>
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
        <script src="js/scripts.js"></script>
    </body>
</html>
