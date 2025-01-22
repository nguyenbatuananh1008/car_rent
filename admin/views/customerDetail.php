

<?php include 'layout/header.php'; ?>
<?php include 'layout/slidebar.php'; ?>
            
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2"></div>
<div class="container mt-5">
    <h2>Thông tin chi tiết khách hàng</h2>
    <div class="card mt-3">
        <div class="card-body">
            <h5>Thông tin khách hàng</h5>
            <p><strong>Mã khách hàng:</strong> <?= htmlspecialchars($customer['id_user']) ?></p>
            <p><strong>Họ tên:</strong> <?= htmlspecialchars($customer['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($customer['email']) ?></p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h5>Lịch sử vé đã đặt</h5>
            <?php if (empty($tickets)): ?>
                <p>Không có lịch sử vé.</p>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã vé</th>
                            <th>Điểm đón</th>
                            <th>Điểm trả</th>
                            <th>Ngày khởi hành</th>
                            <th>Số ghế</th>
                            <th>Giá vé</th>
                            <th>Trạng thái</th>
                            <th>Nhà xe</th>
                            <th>Xe</th>
                            <th>Thành phố</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($tickets as $ticket): ?>
        <tr>
            <td><?= htmlspecialchars($ticket['id_ticket']) ?></td>
            <td><?= htmlspecialchars($ticket['l_pick']) ?></td>
            <td><?= htmlspecialchars($ticket['l_drop']) ?></td>
            <td><?= htmlspecialchars($ticket['departure_date']) ?></td>
            <td><?= htmlspecialchars($ticket['number_seat']) ?></td>
            <td><?= htmlspecialchars($ticket['total_price']) ?> VND</td>
            <td>
                <?php 
                    if ($ticket['status'] == 0) {
                        echo "Chưa đi";
                    } elseif ($ticket['status'] == 1) {
                        echo "Đã đi";
                    } elseif ($ticket['status'] == 2) {
                        echo "Đã hủy";
                    } else {
                        echo "Không rõ";
                    }
                ?>
            </td>
            <td><?= htmlspecialchars($ticket['car_house_name']) ?></td>
            <td><?= htmlspecialchars($ticket['car_name']) ?> (<?= htmlspecialchars($ticket['car_plate']) ?>)</td>
            <td><?= htmlspecialchars($ticket['city_name']) ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>

                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</section>
</div>
</div>
</div>

<?php include 'layout/footer.php'; ?>
