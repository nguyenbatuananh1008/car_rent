<?php include_once 'navbar.php'; ?>
<?php include_once 'slidebar.php'; ?>
<?php include '../module/Database.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lộ trình</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Quản lý lộ trình</h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Quản lý lộ trình</li>
                </ol>
            </div>

            <div class="input-group mb-3">
                <input type="text" class="form-control w-50" id="searchKeyword" placeholder="Tìm kiếm lộ trình">
                <button class="btn btn-outline-secondary" id="btnSearch"><i class="fas fa-search"></i> Tìm kiếm</button>
                <button class="btn btn-primary ms-2" id="btnAdd" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fas fa-plus"></i> Thêm mới
                </button>
            </div>

            


