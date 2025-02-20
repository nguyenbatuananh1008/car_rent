<?php
session_start();
require_once 'module/Ticket.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Lấy id_user từ session
$userId = $_SESSION['user_id'];

// Khởi tạo đối tượng Ticket
$ticket = new Ticket();
// Lấy vé theo các trạng thái khác nhau
$all = $waitingTickets = $confirmedTickets = $goneTickets = $cancelledTickets ='';
$waitingTickets = $ticket->getTicketsByUser($userId, 0);  // Trạng thái "Đang chờ"
$confirmedTickets = $ticket->getTicketsByUser($userId, 1);  // Trạng thái "Đã xác nhận"
$goneTickets = $ticket->getTicketsByUser($userId, 3);  // Trạng thái "Đã đi"
$cancelledTickets = $ticket->getTicketsByUser($userId, 2);  // Trạng thái "Đã hủy"
$noTickets  = empty($waitingTickets) && empty($confirmedTickets) && empty($goneTickets) && empty($cancelledTickets);
$TicketsAll = $ticket->getTicketsByUser($userId);
    foreach ($TicketsAll as $Tickets) {
        $date = $Tickets['date'];  //$Tickets['date'] có định dạng Y-m-d

        // Lấy số thứ tự ngày trong tuần (1 = Thứ 2, ..., 7 = Chủ nhật)
        $dayOfWeek = date('N', strtotime($date));

        // Mảng ánh xạ số thứ tự ngày trong tuần thành tên ngày
        $daysOfWeek = ["CN", "T2", "T3", "T4", "T5", "T6", "T7"];

        // Định dạng lại ngày thành kiểu 'd/m/Y' (22/01/2025)
        $formattedDate = date('d/m/Y', strtotime($date));

        
        $date = $daysOfWeek[$dayOfWeek ] . ", " . $formattedDate . "<br>";
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
                        <li class="list-group-item"><img src="https://229a2c9fe669f7b.cmccloud.com.vn/images/Auth/account-circle.svg" width="30" height="22" alt=""><a href="info.php">Thông tin tài khoản</a></li>
                        <li class="list-group-item" style="background-color: antiquewhite;"><img src="https://229a2c9fe669f7b.cmccloud.com.vn/images/loyalty.svg" width="30" height="22" alt="" >   <a href="">Đơn hàng của tôi</a></li>
                        <li class="list-group-item"><img src="https://229a2c9fe669f7b.cmccloud.com.vn/images/Auth/logout.svg" width="30" height="22" alt="">    <a href="logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
                <!-- Main Content -->
                <div class="col-md-9">
                    <h4 class="mb-4">Đơn hàng của tôi</h4>
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="Waiting-tab" data-bs-toggle="tab" data-bs-target="#Waiting" type="button" role="tab" aria-controls="Waiting" aria-selected="true">Đang chờ</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Confirmed-tab" data-bs-toggle="tab" data-bs-target="#Confirmed" type="button" role="tab" aria-controls="Confirmed" aria-selected="false">Đã xác nhận </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Gone-tab" data-bs-toggle="tab" data-bs-target="#Gone" type="button" role="tab" aria-controls="Gone" aria-selected="false">Đã đi </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab" aria-controls="cancelled" aria-selected="false">Đã hủy</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-4" id="myTabContent">
                        <!-- vé đang chờ -->
                           
                     
                        <div class="tab-pane fade show active" id="Waiting" role="tabpanel" aria-labelledby="Waiting-tab">
                        <?php if (!empty($waitingTickets)): ?>
                            <?php foreach ($waitingTickets as $ticket): ?>
                       
                            <div class="card mt-4">
                            
                                <div class="card-body">
                                
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title"> <?= $date?></h5>
                                        <h1><?= $ticket['from_time'] ?></h1>
                                        <strong><?= $ticket['name_c_house'] ?></strong><br>
                                        <strong>Tên xe: <?= $ticket['c_name'] ?></strong><br>
                                        Số ghế: <strong><?= $ticket['number_seat'] ?></strong><br>
                                        Giá: <strong><?= number_format($ticket['total_price']) ?>VNĐ</strong><br>
                                        Biển số xe : <strong><?= $ticket['c_plate'] ?></strong>
                                        </div>
                                        <div>
                                            <span class="badge bg-success p-2">Đang chờ</span>
                                            <a href="#" class="d-block mt-2 text-primary">Hủy</a>
                                        </div>
                                    </div>
                                    
                                </div>
                               
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đang chờ xác nhận. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
            
        </div>
        <?php endif; ?>

                        </div>
                        
                    
                        <!-- Đã xác nhận -->
                        <div class="tab-pane fade" id="Confirmed" role="tabpanel" aria-labelledby="Confirmed-tab">
                        <?php if (!empty($confirmedTickets)): ?>
                            <?php foreach ($confirmedTickets as $ticket): ?>
                            <div class="card mt-4">
                           
                                <div class="card-body">
                                
                                    <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title"> <?= $date?></h5>
                                        <h1><?= $ticket['from_time'] ?></h1>
                                        <strong><?= $ticket['name_c_house'] ?></strong><br>
                                        <strong>Tên xe: <?= $ticket['c_name'] ?></strong><br>
                                        Số ghế: <strong><?= $ticket['number_seat'] ?></strong><br>
                                        Giá: <strong><?= number_format($ticket['total_price']) ?>VNĐ</strong><br>
                                        Biển số xe : <strong><?= $ticket['c_plate'] ?></strong>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary p-2">Đã xác nhận</span>
                                            
                                        </div>
                                    
                                </div>
                                </div>
                                    
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã được xác nhận. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
        <?php endif; ?>
 
                        </div>
                        
                        
                        <!-- Đã đi -->
                        <div class="tab-pane fade" id="Gone" role="Gone" aria-labelledby="Gone-tab">
                        <?php if (!empty($goneTickets)): ?>
                            <?php foreach ($goneTickets as $ticket): ?>
                            <div class="card mt-4">
                                <div class="card-body">
                                    
                                    <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title"> <?= $date?></h5>
                                        <h1><?= $ticket['from_time'] ?></h1>
                                        <strong><?= $ticket['name_c_house'] ?></strong><br>
                                        <strong>Tên xe: <?= $ticket['c_name'] ?></strong><br>
                                        Số ghế: <strong><?= $ticket['number_seat'] ?></strong><br>
                                        Giá: <strong><?= number_format($ticket['total_price']) ?>VNĐ</strong><br>
                                        Biển số xe : <strong><?= $ticket['c_plate'] ?></strong>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary p-2">Đã đi</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>             
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã hoàn thành. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
        <?php endif; ?>
    
                        </div>
                        <!-- đã hủy -->
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <?php if (!empty($cancelledTickets)): ?>
                            <?php foreach ($cancelledTickets as $ticket): ?>
                            <div class="card mt-4">
                                <div class="card-body">
                                    
                                    <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title"> <?= $date?></h5>
                                        <h1><?= $ticket['from_time'] ?></h1>
                                        <strong><?= $ticket['name_c_house'] ?></strong><br>
                                        <strong>Tên xe: <?= $ticket['c_name'] ?></strong><br>
                                        Số ghế: <strong><?= $ticket['number_seat'] ?></strong><br>
                                        Giá: <strong><?= number_format($ticket['total_price']) ?>VNĐ</strong><br>
                                        Biển số xe : <strong><?= $ticket['c_plate'] ?></strong>
                                        </div>
                                        <div>
                                            <span class="badge bg-danger p-2">Đã Hủy</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                    <?php else: ?>
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã hủy. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
        <?php endif; ?>

                        </div>
                       
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
