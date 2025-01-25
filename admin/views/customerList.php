<?php include 'navbar.php'; ?>
<?php include 'slidebar.php'; ?>
<?php
include '../module/auth.php';
checkAccess(0);
include '../module/customerHandler.php';

// Kiểm tra nếu có tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$customers = getCustomers($search); // Lấy danh sách khách hàng (có tìm kiếm nếu có)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Khách Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    
    <div id="layoutSidenav_content">
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Danh sách khách hàng</h3>
                <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                <li class="breadcrumb-item active">Quản lý nhà xe</li>
            </div>
            
                <!-- Thanh tìm kiếm -->
                <form method="GET" action="" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm khách hàng..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </form>

                <!-- Bảng danh sách khách hàng -->
                
                <div class="card shadow">

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Mã khách</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <div>
                                <?php if (empty($customers)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Không tìm thấy khách hàng phù hợp.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($customer['id_user']) ?></td>
                                            <td><?= htmlspecialchars($customer['name']) ?></td>
                                            <td><?= htmlspecialchars($customer['email']) ?></td>
                                            <td>
                                                <a href="editCustomer.php?id_user=<?= $customer['id_user'] ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="../module/customerHandler.php?delete_id=<?= $customer['id_user'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                   
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
