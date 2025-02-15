
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
                      
                       
                            <div class="card">
                            
                                <div class="card-body">
                                
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title">Ngày đi </h5>
                                    <p>Giờ xuất phát:</p>
                                    <p>Nhà xe: </p>
                                    <p>Tên xe:</p>
                                    <p>Điểm đi: </p>
                                    <p>Điểm đến: </p>
                                    <p>Số lượng ghế : </p>
                            
                                        </div>
                                        <div>
                                            <span class="badge bg-success p-2">Đang chờ</span>
                                            <a href="#" class="d-block mt-2 text-primary">Hủy</a>
                                        </div>
                                    </div>
                                    
                                </div>
                               
                            </div>
                        
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đang chờ xác nhận. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>

                        </div>
                        
                    
                        <!-- Đã xác nhận -->
                        <div class="tab-pane fade" id="Confirmed" role="tabpanel" aria-labelledby="Confirmed-tab">
                
                            <div class="card">
                           
                                <div class="card-body">
                                
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title">Ngày đi :</h5>
                                    <p>Giờ xuất phát: </p>
                                    <p>Nhà xe: </p>
                                    <p>Tên xe: </p>
                                    <p>Điểm đi: </p>
                                    <p>Điểm đến: </p>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary p-2">Đã xác nhận</span>
                                            
                                        </div>
                                    
                                </div>
                                </div>
                                    
                            </div>
                        
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã được xác nhận. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
 
                        </div>
                        
                        
                        <!-- Đã đi -->
                        <div class="tab-pane fade" id="Gone" role="Gone" aria-labelledby="Gone-tab">
                    
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title">Ngày đi :</h5>
                                    <p>Giờ xuất phát:</p>
                                    <p>Nhà xe: </p>
                                    <p>Tên xe: </p>
                                    <p>Điểm đi:</p>
                                    <p>Điểm đến:</p>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary p-2">Đã đi</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã hoàn thành. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>
    
                        </div>
                        <!-- đã hủy -->
                        <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                            <div class="card">
                                <div class="card-body">
                                    
                                    <div class="d-flex justify-content-between">
                                        <div>
                                        <h5 class="card-title">Ngày đi : </h5>
                                    <p>Giờ xuất phát: </p>
                                    <p>Nhà xe: </p>
                                    <p>Tên xe: </p>
                                    <p>Điểm đi:</p>
                                    <p>Điểm đến:</p>    
                                        </div>
                                        <div>
                                            <span class="badge bg-danger p-2">Đã Hủy</span>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
        <div class="alert alert-info mt-3">
            Bạn chưa có chuyến đi nào đã hủy. 
            <a href="search_trip.php" class="text-primary">Đặt chuyến ngay</a>.
        </div>

                        </div>
                       
                    </div>
                    
                </div>
             
            <div class="alert alert-info">Không có lịch sử vé để hiển thị.</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
