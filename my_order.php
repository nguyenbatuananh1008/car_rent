<?php
require_once 'module/db.php';
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

$tickets = $userID ? $ticket->getTicketsByUser($userID) : [];
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
                        <li class="list-group-item fw-bold">Thông tin tài khoản</li>
                        <li class="list-group-item active"><a href="">Đơn hàng của tôi</a></li>
                        <li class="list-group-item"><a href="">Nhận xét chuyến đi</a></li>
                        <li class="list-group-item"><a href="logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
                <?php if ($userID && !empty($tickets)): ?>
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
                        <?php
                        $hasWaitingTickets = false; 
                        foreach ($tickets as $ticket): ?>
                            <?php if ($ticket['status'] == 0): 
                            $hasWaitingTickets = true; 
                                ?>
                            <div class="card">
                            
                                <div class="card-body">
                                
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title"><?= htmlspecialchars($ticket['date']) ?></h5>
                                    <p>Giờ xuất phát: <?= htmlspecialchars($ticket['t_pick']) ?></p>
                                    <p>Nhà xe: <?= htmlspecialchars($ticket['name_c_house']) ?></p>
                                    <p>Tên xe: <?= htmlspecialchars($ticket['c_name']) ?></p>
                                    <p>Điểm đi: <?= htmlspecialchars($ticket['from_city']) ?></p>
                                    <p>Điểm đến: <?= htmlspecialchars($ticket['to_city']) ?></p>
                                    <p>Số lượng ghế : <?= htmlspecialchars($ticket['number_seat']) ?></p>
                            
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
                        
                    
                        <!-- Đã xác nhận -->
                        <div class="tab-pane fade" id="Confirmed" role="tabpanel" aria-labelledby="Confirmed-tab">
                        <?php 
                        $hasConfirmedTickets = false;
                        foreach ($tickets as $ticket): ?>
                            <?php if ($ticket['status'] == 1): 
                                 $hasConfirmedTickets = true;?>
                            <div class="card">
                           
                                <div class="card-body">
                                
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title"><?= htmlspecialchars($ticket['date']) ?></h5>
                                    <p>Giờ xuất phát: <?= htmlspecialchars($ticket['t_pick']) ?></p>
                                    <p>Nhà xe: <?= htmlspecialchars($ticket['name_c_house']) ?></p>
                                    <p>Tên xe: <?= htmlspecialchars($ticket['c_name']) ?></p>
                                    <p>Điểm đi: <?= htmlspecialchars($ticket['from_city']) ?></p>
                                    <p>Điểm đến: <?= htmlspecialchars($ticket['to_city']) ?></p>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary p-2">Đã xác nhận</span>
                                            
                                        </div>
                                    
                                </div>
                                </div>
                                    
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (!$hasConfirmedTickets): ?>
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã được xác nhận. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
    <?php endif; ?>
                        </div>
                        
                        
                        <!-- Đã đi -->
                        <div class="tab-pane fade" id="Gone" role="Gone" aria-labelledby="Gone-tab">
                        <?php
                         $hasGoneTickets = false;
                         foreach ($tickets as $ticket): ?>
                            <?php if ($ticket['status'] == 2): 
                                $hasGoneTickets = true;
                                ?>
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title"><?= htmlspecialchars($ticket['date']) ?></h5>
                                    <p>Giờ xuất phát: <?= htmlspecialchars($ticket['t_pick']) ?></p>
                                    <p>Nhà xe: <?= htmlspecialchars($ticket['name_c_house']) ?></p>
                                    <p>Tên xe: <?= htmlspecialchars($ticket['c_name']) ?></p>
                                    <p>Điểm đi: <?= htmlspecialchars($ticket['from_city']) ?></p>
                                    <p>Điểm đến: <?= htmlspecialchars($ticket['to_city']) ?></p>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary p-2">Đã đi</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php endforeach; ?>
                            <?php if (!$hasGoneTickets): ?>
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã hoàn thành. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
    <?php endif; ?>
                        </div>


                        <!-- đã hủy -->
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <?php 
                          $hasCancelledTickets = false;
                        foreach ($tickets as $ticket): 

                            ?>
                            <?php if ($ticket['status'] == 3): 
                             $hasCancelledTickets = true; 
                                ?>
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title"><?= htmlspecialchars($ticket['date']) ?></h5>
                                    <p>Giờ xuất phát: <?= htmlspecialchars($ticket['t_pick']) ?></p>
                                    <p>Nhà xe: <?= htmlspecialchars($ticket['name_c_house']) ?></p>
                                    <p>Tên xe: <?= htmlspecialchars($ticket['c_name']) ?></p>
                                    <p>Điểm đi: <?= htmlspecialchars($ticket['from_city']) ?></p>
                                    <p>Điểm đến: <?= htmlspecialchars($ticket['to_city']) ?></p>    
                                        </div>
                                        <div>
                                            <span class="badge bg-danger p-2">Đã Hủy</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if (!$hasCancelledTickets): ?>
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã hủy. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
    <?php endif; ?>
                        </div>
                       
                    </div>
                    
                </div>
                <?php else: ?>
            <div class="alert alert-info">Không có lịch sử vé để hiển thị.</div>
                  <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
