<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>Dashboard - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
<link href="../css/styles.css" rel="stylesheet" />
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<?php
// Khởi động session nếu chưa khởi động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy tên tài khoản, loại tài khoản và ảnh từ session (nếu tồn tại)
$username = isset($_SESSION['name']) ? $_SESSION['name'] : "Khách";
$usertype = isset($_SESSION['usertype']) && $_SESSION['usertype'] == 1 ? "Admin" : "Nhân viên";
$image = isset($_SESSION['image']) ? $_SESSION['image'] : "default.png"; // Default image nếu không có ảnh

?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark " style="ba">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php">Admin Panel</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form method="get" action="" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            
        </div>
    </form>

    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= $image ?>"  style="">
                <?= htmlspecialchars($username) ?> (<?= htmlspecialchars($usertype) ?>)
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
</body>
</html>
