<?php
session_start();
require_once 'module/User.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$userId = $_SESSION['user_id']; // Lấy ID người dùng từ session

include_once 'module/db.php'; // Bao gồm file kết nối cơ sở dữ liệu
$db = new Database();
$conn = $db->connect();

// Tạo đối tượng User và lấy thông tin người dùng
$user = new User($conn);
$userInfo = $user->getUserInfo($userId); // Lấy thông tin người dùng theo id

$name = $userInfo['name']; // Tên người dùng
$email = $userInfo['email']; // Email người dùng
$successMessage = ''; // Biến để chứa thông báo thành công hoặc thất bại
// Kiểm tra nếu form được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy tên mới từ form
    $newName = $_POST['fullName'];

    // Cập nhật tên mới vào cơ sở dữ liệu
    if ($user->updateProfile($userId, $newName, $email)) {
        $successMessage = "Cập nhật tên thành công!";
        $name = $newName; // Cập nhật lại giá trị tên sau khi sửa
    } else {
        $successMessage = "Cập nhật tên thất bại!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "layout/header.php"; ?>
<div class="container d-flex align-items-center justify-content-center pt-5">
    <div class="container mt-5 pt-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">  
                <ul class="list-group">
                    <li class="list-group-item "style="background-color: antiquewhite;"><img src="https://229a2c9fe669f7b.cmccloud.com.vn/images/Auth/account-circle.svg" width="30" height="22" alt=""><a href="info.php">Thông tin tài khoản</a></li>
                    <li class="list-group-item"><img src="https://229a2c9fe669f7b.cmccloud.com.vn/images/loyalty.svg" width="30" height="22" alt=""> <a href="my_order.php">Đơn hàng của tôi</a></li>
                    <li class="list-group-item"><img src="https://229a2c9fe669f7b.cmccloud.com.vn/images/Auth/logout.svg" width="30" height="22" alt=""> <a href="logout.php">Đăng xuất</a></li>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h4 class="mb-4">Thông tin tài khoản</h4> 
                <div class="card p-4">
                    <form method="POST">
                        <!-- Hiển thị tên và email nhưng không cho phép chỉnh sửa -->
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Họ và tên*</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>
                        <hr>
                      
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </form>
                </div>          
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
