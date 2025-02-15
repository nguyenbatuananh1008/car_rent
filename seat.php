<?php

require_once 'module/Ticket.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kết nối Database
$db = (new Database())->connect();
$ticket = new Ticket($db);


// Nếu không có session ID user, mặc định không hiển thị vé
$userID = $_SESSION['id_user'] ?? null;
$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$tickets = $ticket->getTicketsByUser($userID);

if (!empty($tickets)) {
    foreach ($tickets as $ticketData) {
        echo "<div class='ticket'>";
        echo "<h3>Thông tin vé</h3>";
        echo "<p><strong>Nhà xe:</strong> " . htmlspecialchars($ticketData['name_c_house']) . "</p>";
        echo "<p><strong>Tên xe:</strong> " . htmlspecialchars($ticketData['c_name']) . "</p>";
        echo "<p><strong>Biển số xe:</strong> " . htmlspecialchars($ticketData['c_plate']) . "</p>";
        echo "<p><strong>Giá vé:</strong> " . number_format($ticketData['total_price']) . " đ</p>";
        echo "<p><strong>Điểm đón:</strong> " . htmlspecialchars($ticketData['from_location']) . " (Thời gian: " . htmlspecialchars($ticketData['from_time']) . ")</p>";
        echo "<p><strong>Điểm trả:</strong> " . htmlspecialchars($ticketData['to_location']) . " (Thời gian: " . htmlspecialchars($ticketData['to_time']) . ")</p>";
        echo "<p><strong>Số ghế:</strong> " . htmlspecialchars($ticketData['number_seat']) . "</p>";
        echo "<p><strong>Ngày xuất phát:</strong> " . htmlspecialchars($ticketData['date']) . "</p>";
        echo "<p><strong>Phương thức thanh toán:</strong> " . ($ticketData['method'] == 0 ? 'Tiền mặt' : ($ticketData['method'] == 1 ? 'Thẻ' : 'Chuyển khoản')) . "</p>";
        echo "</div>";  
    }
} else {
    echo "<p>Không có vé nào được tìm thấy.</p>";
}
?>
<?php
if ($userID && !empty($tickets)): ?>
    <div class="col-md-9">
        <h4 class="mb-4">Đơn hàng của tôi</h4>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="Waiting-tab" data-bs-toggle="tab" data-bs-target="#Waiting" type="button" role="tab" aria-controls="Waiting" aria-selected="true">Đang chờ</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="Confirmed-tab" data-bs-toggle="tab" data-bs-target="#Confirmed" type="button" role="tab" aria-controls="Confirmed" aria-selected="false">Đã xác nhận</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="Gone-tab" data-bs-toggle="tab" data-bs-target="#Gone" type="button" role="tab" aria-controls="Gone" aria-selected="false">Đã đi</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">Đã hủy</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="myTabContent">
            <div class="tab-pane fade show active" id="Waiting" role="tabpanel" aria-labelledby="Waiting-tab">
                <?php
                $hasWaitingTickets = false;
                foreach ($tickets as $ticket): ?>
                    <?php if ($ticket['status'] == 0): 
                        $hasWaitingTickets = true; ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title"><?= htmlspecialchars($ticket['date']) ?></h5>
                                    <p>Giờ xuất phát: <?= htmlspecialchars($ticket['t_pick']) ?></p>
                                    <p>Nhà xe: <?= htmlspecialchars($ticket['name_c_house']) ?></p>
                                    <p>Tên xe: <?= htmlspecialchars($ticket['c_name']) ?></p>
                                    <p>Biển số xe: <?= htmlspecialchars($ticket['c_plate']) ?></p>
                                    <p>Điểm đi: <?= htmlspecialchars($ticket['from_city']) ?></p>
                                    <p>Điểm đến: <?= htmlspecialchars($ticket['to_city']) ?></p>
                                    <p>Số lượng ghế: <?= htmlspecialchars($ticket['number_seat']) ?></p>
                                    <p>Phương thức thanh toán: <?= $ticket['method'] == 0 ? 'Tiền mặt' : ($ticket['method'] == 1 ? 'Thẻ' : 'Chuyển khoản') ?></p>
                                </div>
                                <div>
                                    <span class="badge bg-success p-2">Đang chờ</span>
                                    <a href="#" class="d-block mt-2 text-primary">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (!$hasWaitingTickets): ?>
                    <div class="alert alert-info mt-3">
                        Bạn chưa có chuyến đi nào đang chờ xác nhận. 
                        <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
                    </div>
                <?php endif; ?>
            </div>
            <!-- Tương tự cho các tab "Đã xác nhận", "Đã đi", và "Đã hủy" -->
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">Không có lịch sử vé để hiển thị.</div>
<?php endif; ?>

