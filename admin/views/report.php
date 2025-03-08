<?php
ob_start(); // Bắt đầu output buffering

include_once 'navbar.php';
include_once 'slidebar.php';
include_once '../module/Database.php'; 
include '../module/auth.php';
checkAccess(1); // Kết nối database

$database = new Database();
$pdo = $database->connect();

try {
    // Lấy danh sách nhà xe
    $houseQuery = "SELECT id_c_house, name_c_house FROM car_house ORDER BY name_c_house";
    $stmtHouse = $pdo->prepare($houseQuery);
    $stmtHouse->execute();
    $carHouses = $stmtHouse->fetchAll(PDO::FETCH_ASSOC);

    // Lấy tham số từ người dùng
    $selectedHouse = isset($_GET['house']) ? $_GET['house'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : 'month';

    $chartData = [];
    
    if ($selectedHouse) {
        if ($type == 'year') {
            $sql = "SELECT DATE_FORMAT(t.date, '%Y') AS period, SUM(t.total_price) AS total_revenue
                    FROM ticket t
                    JOIN trip tr ON t.id_trip = tr.id_trip
                    WHERE tr.id_c_house = :house AND t.status != 0
                    GROUP BY DATE_FORMAT(t.date, '%Y')
                    ORDER BY period DESC";
        } elseif ($type == 'week') {
            $sql = "SELECT CONCAT(YEAR(t.date), '-W', WEEK(t.date, 3)) AS period, SUM(t.total_price) AS total_revenue
                    FROM ticket t
                    JOIN trip tr ON t.id_trip = tr.id_trip
                    WHERE tr.id_c_house = :house AND t.status != 0
                    GROUP BY YEAR(t.date), WEEK(t.date, 3)
                    ORDER BY period DESC";
        } else {
            $sql = "SELECT DATE_FORMAT(t.date, '%Y-%m') AS period, SUM(t.total_price) AS total_revenue
                    FROM ticket t
                    JOIN trip tr ON t.id_trip = tr.id_trip
                    WHERE tr.id_c_house = :house AND t.status != 0
                    GROUP BY DATE_FORMAT(t.date, '%Y-%m')
                    ORDER BY period DESC";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['house' => $selectedHouse]);
        $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $chartDataJson = json_encode($chartData);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Xuất file Excel với định dạng hợp lệ
if (isset($_GET['export']) && $selectedHouse) {
    ob_end_clean(); // Xóa buffer trước khi xuất file

    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=doanh_thu.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<html><meta http-equiv='Content-Type' content='text/html; charset=utf-8'><body>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>Thời gian</th><th>Doanh thu (VND)</th></tr>";

    foreach ($chartData as $data) {
        echo "<tr><td>{$data['period']}</td><td>{$data['total_revenue']}</td></tr>";
    }

    echo "</table></body></html>";
    exit;
}

ob_end_flush(); // Đẩy dữ liệu ra trình duyệt
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 mt-5">Thống kê doanh thu theo nhà xe</h1>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Chọn nhà xe:</label>
                <select id="houseSelect" class="form-control">
                    <option value="">Chọn nhà xe</option>
                    <?php foreach ($carHouses as $house) : ?>
                        <option value="<?= $house['id_c_house']; ?>" <?= ($house['id_c_house'] == $selectedHouse) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($house['name_c_house']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Thống kê theo:</label>
                <select id="typeSelect" class="form-control">
                    <option value="week" <?= $type == 'week' ? 'selected' : '' ?>>Tuần</option>
                    <option value="month" <?= $type == 'month' ? 'selected' : '' ?>>Tháng</option>
                    <option value="year" <?= $type == 'year' ? 'selected' : '' ?>>Năm</option>
                </select>
            </div>
        </div>

        <div class="text-center">
            <button id="filterButton" class="btn btn-primary mb-3">Xem thống kê</button>
            <?php if ($selectedHouse) : ?>
                <a href="?house=<?= $selectedHouse; ?>&type=<?= $type; ?>&export=true" class="btn btn-success mb-3">Xuất Excel</a>
            <?php endif; ?>
        </div>

        <canvas id="revenueChart" class="mt-4"></canvas>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("filterButton").addEventListener("click", function () {
                    const house = document.getElementById("houseSelect").value;
                    const type = document.getElementById("typeSelect").value;
                    if (!house) { alert("Vui lòng chọn nhà xe."); return; }
                    window.location.href = `?house=${house}&type=${type}`;
                });

                const data = <?= $chartDataJson; ?>;
                const labels = data.map(row => row.period);
                const revenues = data.map(row => row.total_revenue);

                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh thu (VND)',
                            data: revenues,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true } }
                    }
                });
            });
        </script>
    </div>
    
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</html>
