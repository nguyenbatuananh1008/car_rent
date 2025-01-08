<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_admin, email, password FROM tbladmin  WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Kiểm tra nếu có người dùng với email này
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password == $row['password']) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $row['id_user'];
            $_SESSION['email'] = $row['email'];

            // Chuyển hướng về trang chủ
            header('Location: index.php');
            exit();
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Không tìm thấy tài khoản với email này!";
    }

    // Đóng kết nối
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/style.css">  
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Login Admin</header>
                <form method="post" action="#">
                    <div class="field input-field">
                        <input type="email" name="email" placeholder="Email" class="input" required>
                    </div>
                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Password" class="password" required>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>
                    <div class="form-link">
                        <a href="#" class="forgot-pass">Forgot password?</a>
                    </div>
                    <div class="field button-field">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="js/script.js"></script>
</body>
</html>
