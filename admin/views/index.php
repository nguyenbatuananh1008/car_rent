<?php
include '../module/auth.php';
checkAccess(0); ?>
<?php require '../module/Database.php'; ?>
<?php
$db = new Database();
$conn = $db->connectBee();
?>
<?php require '../module/formart.php' ?>
<?php include 'navbar.php'; ?>
<?php include 'slidebar.php'; ?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Người dùng
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">11</div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-primary text-white" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-users fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Đơn mới
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">56</div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-warning text-white" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-shopping-cart fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Đơn hoàn thành
                                    </div>  
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">123</div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-success text-white" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Đơn hủy
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-danger text-white" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-times fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            $sqlOrders = "
    SELECT 
        date, 
        COUNT(id_ticket) AS total_orders
    FROM ticket
    GROUP BY date
    ORDER BY date ASC
";
            $resultOrders = $conn->query($sqlOrders);
            $orderDates = [];
            $orderCounts = [];
            if ($resultOrders->num_rows > 0) {
                while ($row = $resultOrders->fetch_assoc()) {
                    
                    $orderDates[] = formatDay($row['date']);
                    $orderCounts[] = (int)$row['total_orders'];
                }
            }

            $sqlRevenue = "
    SELECT 
        date, 
        SUM(total_price) AS total_revenue
    FROM ticket
    WHERE status IN (1, 3)
    GROUP BY date
    ORDER BY date ASC
";
            $resultRevenue = $conn->query($sqlRevenue);
            $revenueDates = [];
            $revenueTotals = [];
            if ($resultRevenue->num_rows > 0) {
                while ($row = $resultRevenue->fetch_assoc()) {
                    $revenueDates[] = formatDay($row['date']);
                    $revenueTotals[] = (float)$row['total_revenue'];
                }
            }
            ?>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Đơn đặt
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-chart-bar me-1"></i>
                                Doanh thu
                            </div>
                            <button id="exportRevenuePdf" class="btn btn-sm btn-outline-primary">Xuất PDF</button>
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Datatable -->
                <?php
                $sql = "SELECT id_ticket, name, phone, email, date, total_price, status FROM ticket";
                $result = $conn->query($sql);
                ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Booking
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Ngày</th>
                                    <th>Giá</th>
                                    <th>Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id_ticket'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . formatDay($row['date']) . "</td>";
                                        echo "<td>" . $row['total_price'] . "</td>";

                                        $statusText = '';
                                        $statusBadgeClass = '';
                                        switch ($row['status']) {
                                            case 0:
                                                $statusText = 'Đang chờ';
                                                $statusBadgeClass = 'bg-warning';
                                                break;
                                            case 1:
                                                $statusText = 'Đã xác nhận';
                                                $statusBadgeClass = 'bg-success';
                                                break;
                                            case 2:
                                                $statusText = 'Đã hủy';
                                                $statusBadgeClass = 'bg-danger';
                                                break;
                                            case 3:
                                                $statusText = 'Đã đi';
                                                $statusBadgeClass = 'bg-info';
                                                break;
                                            default:
                                                $statusText = 'Không xác định';
                                                $statusBadgeClass = 'bg-secondary';
                                        }
                                        echo "<td><span class='badge {$statusBadgeClass}'>$statusText</span></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
    </main>
    <?php include 'footer.php'; ?>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #1cc88a, #4e73df);
    }
</style>


<script src="../js/scripts.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
<!-- <script src="../assets/demo/chart-area-demo.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="../js/datatables-simple-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous"></script>

<script>
    var orderDates = <?php echo json_encode($orderDates); ?>;
    var orderCounts = <?php echo json_encode($orderCounts); ?>;
    var revenueDates = <?php echo json_encode($revenueDates); ?>;
    var revenueTotals = <?php echo json_encode($revenueTotals); ?>;

    // "Đơn đặt"
    var ctxArea = document.getElementById("myAreaChart").getContext("2d");
    new Chart(ctxArea, {
        type: "line",
        data: {
            labels: orderDates,
            datasets: [{
                label: "Số đơn đặt",
                data: orderCounts,
                backgroundColor: "rgba(0, 4, 255, 0.2)",
                borderColor: "rgba(2,117,216,1)",
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Ngày"
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: "Số đơn đặt"
                    },
                    beginAtZero: true,
                    // min : 0,
                    // max : 100,
                    ticks: {
                        stepSize: 2,
                        callback: function(value) {
                            return value.toFixed(0); // Hiển thị số nguyên
                        }
                    }
                }
            }
        }
    });

    //  "Doanh thu"
    var ctxBar = document.getElementById("myBarChart").getContext("2d");
    new Chart(ctxBar, {
        type: "bar",
        data: {
            labels: revenueDates,
            datasets: [{
                label: "Doanh thu",
                data: revenueTotals,
                backgroundColor: "rgba(167, 99, 255, 0.96)",
                borderColor: "rgb(55, 0, 255)",
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Ngày"
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: "Doanh thu"
                    },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50000,
                        callback: function(value) {
                            return value.toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            });
                        }
                    }
                }
            }
        }
    });

    
</script>