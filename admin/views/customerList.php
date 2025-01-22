<?php
include '../module/auth.php';
checkAccess(0); 
include '../module/customerHandler.php';

// Kiểm tra nếu có tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : null;
$customers = getCustomers($search); // Lấy danh sách khách hàng (có tìm kiếm nếu có)
?>

<?php include 'navbar.php'; ?>
<?php include 'slidebar.php'; ?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lý khách hàng</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Thanh tìm kiếm bên dưới tiêu đề -->
            <div class="container-fluid">
                <div class="row mb-3">
                    <div class="col-12">
                        <form class="input-group" method="GET" action="">
                            
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control" 
                                placeholder="Tìm kiếm khách hàng..."
                                value="<?= htmlspecialchars($search) ?>" />
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> <!-- Icon FontAwesome -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Hiển thị bảng danh sách khách hàng -->
                                    <table id="customerTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Mã khách</th>
                                                <th>Họ tên</th>
                                                <th>Email</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
    <a href="editCustomer.php?id_user=<?= $customer['id_user'] ?>" class="btn btn-primary btn-sm">Sửa</a>
    <a href="../module/customerHandler.php?delete_id=<?= $customer['id_user'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
    <a href="customerDetail.php?id_user=<?= $customer['id_user'] ?>" class="btn btn-info btn-sm">Chi tiết</a>
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
            </section>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
