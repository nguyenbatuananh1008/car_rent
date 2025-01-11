<?php include 'Database.php'; ?>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_admin, email, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

       
        if ($password == $row['password']) {
            $_SESSION['admin_id'] = $row['id_admin'];
            $_SESSION['email'] = $row['email'];
            echo "Đăng nhập thành công!";
            
            header('Location: ../views/index.php');
            exit();
        } else {
            echo "Sai mật khẩu!";
            header('Location: login.php');
        }
    } else {
        echo "Không tìm thấy tài khoản với email này!";
    }

   
    $conn->close();
}
?>
