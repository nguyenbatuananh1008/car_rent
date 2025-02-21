  <?php

  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
  
  include_once 'module/db.php'; // Bao gồm file kết nối cơ sở dữ liệu
  include_once 'module/User.php'; // Bao gồm lớp User
  
  // Khởi tạo kết nối đến cơ sở dữ liệu
  $db = new Database();
  $conn = $db->connect();
  
  // Kiểm tra nếu người dùng đã đăng nhập và có session 'user_id'
  if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id']; // Lấy ID người dùng từ session
  
      // Khởi tạo đối tượng User và lấy thông tin người dùng
      $user = new User($conn);
      $userInfo = $user->getUserInfo($userId);
  
      // Kiểm tra nếu truy vấn trả về kết quả
      if ($userInfo !== false) {
          $name = $userInfo['name']; // Tên người dùng
          $email = $userInfo['email']; // Email người dùng
      } else {
          // Nếu không tìm thấy người dùng, gán giá trị mặc định
          $name = 'Guest';
          $email = '';
      }
  } else {
      // Nếu người dùng chưa đăng nhập, gán giá trị mặc định
      $name = 'Guest';
      $email = '';
  }
  ?>
  

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đặt vé xe</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/trip.css" rel="stylesheet">
  <link href="css/trip_results.css" rel="stylesheet">
  <link href="css/my_order.css" rel="stylesheet">
 
<link rel="stylesheet" href="css/index.css">
 
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="main clearfix position-relative">
  <div class="main_1 clearfix position-absolute top-0 w-100">
    <section id="header">
      <nav class="navbar navbar-expand-md navbar-light custom-navbar bg-dark" id="navbar_sticky">
        <div class="container-xl">
          <a class="navbar-brand fs-3 p-0 fw-bold text-white" href="index.php"><i class="fa fa-car col_oran me-1 fs-2 align-middle"></i> Đặt Xe</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>A
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
              </li>  
             
              <li class="nav-item">
                <a class="nav-link" href="blog.php">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="team.php">Team</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
              </li>
            </ul>
            <ul class="navbar-nav mb-0 ms-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
  <li class="nav-item">
    <a class="nav-link" href="info.php"><?= htmlspecialchars($name ) ?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="logout.php">Logout</a>
  </li>
  <li class="nav-item">
  <a class="nav-link" href="my_order.php">Đơn hàng của tôi</a>
  </li>
<?php else: ?>
  <li class="nav-item">
    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Sign In</a>
  </li>
  <li class="nav-item">
    <a class="nav-link button_2 ms-2 me-2" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register <i class="fa fa-check-circle ms-1"></i></a>
  </li>
<?php endif; ?>

            </ul>
          </div>
        </div>
      </nav>
    </section>
  </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Đăng Nhập</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="loginError" class="alert alert-danger" style="display: none;"></div>
        <form id="loginForm">
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="loginEmail" required>
          </div>
          <div class="mb-3">
            <label for="loginPassword" class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" id="loginPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>
      </div>
    </div>
  </div>
</div>








<!-- Modal Đăng Ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Đăng Ký</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="registerError" class="alert alert-danger" style="display: none;"></div>
        <form id="registerForm">
          <div class="mb-3">
            <label for="registerName" class="form-label">Họ và Tên</label>
            <input type="text" name="name" class="form-control" id="registerName" required>
          </div>
          <div class="mb-3">
            <label for="registerEmail" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="registerEmail" required>
          </div>
          <div class="mb-3">
            <label for="registerPassword" class="form-label">Mật khẩu</label>
            <input type="password" name="password" class="form-control" id="registerPassword" required>
          </div>
          <div class="mb-3">
            <label for="registerConfirmPassword" class="form-label">Nhập lại mật khẩu</label>
            <input type="password" name="confirm_password" class="form-control" id="registerConfirmPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Đăng Ký</button>
        </form>
      </div>
    </div>
  </div>
</div>




</body>



</html>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('loginForm').addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(event.target);

        fetch('module/process_login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'index.php';
            } else {
                document.getElementById('loginError').style.display = 'block';
                document.getElementById('loginError').textContent = data.message;
            }
        });
    });
});


</script>
<script>
 document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('registerForm').addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(event.target);

        fetch('module/process_register.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hiển thị thông báo và xử lý modal
                alert('Đăng ký thành công! Vui lòng đăng nhập.');
                
                // Ẩn modal đăng ký
                const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                registerModal.hide();
                
                // Hiển thị modal đăng nhập
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
            } else {
                // Hiển thị lỗi nếu đăng ký thất bại
                const errorDiv = document.getElementById('registerError');
                errorDiv.style.display = 'block';
                errorDiv.textContent = data.message;
            }
        });
    });
});
  


</script>

