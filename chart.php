<?php
// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'dat_ve';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        // Truy vấn SQL dựa trên loại thống kê
        if ($type == 'year') {
            $sql = "SELECT 
                        DATE_FORMAT(t.date, '%Y') AS period, 
                        SUM(t.total_price) AS total_revenue
                    FROM ticket t
                    JOIN trip tr ON t.id_trip = tr.id_trip
                    WHERE tr.id_c_house = :house
                    GROUP BY DATE_FORMAT(t.date, '%Y')
                    ORDER BY period DESC";
        } elseif ($type == 'week') {
            $sql = "SELECT 
                        CONCAT(YEAR(t.date), '-W', WEEK(t.date, 3)) AS period, 
                        SUM(t.total_price) AS total_revenue
                    FROM ticket t
                    JOIN trip tr ON t.id_trip = tr.id_trip
                    WHERE tr.id_c_house = :house
                    GROUP BY YEAR(t.date), WEEK(t.date, 3)
                    ORDER BY period DESC";
        } else {
            $sql = "SELECT 
                        DATE_FORMAT(t.date, '%Y-%m') AS period, 
                        SUM(t.total_price) AS total_revenue
                    FROM ticket t
                    JOIN trip tr ON t.id_trip = tr.id_trip
                    WHERE tr.id_c_house = :house
                    GROUP BY DATE_FORMAT(t.date, '%Y-%m')
                    ORDER BY period DESC";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['house' => $selectedHouse]);
        $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $chartData = json_encode($chartData);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Thống kê doanh thu theo nhà xe</h1>

        <!-- Chọn nhà xe -->
        <div class="mb-3">
            <label class="form-label">Chọn nhà xe:</label>
            <select id="houseSelect" class="form-select">
                <option value="">Chọn nhà xe</option>
                <?php foreach ($carHouses as $house) : ?>
                    <option value="<?= $house['id_c_house']; ?>" <?= ($house['id_c_house'] == $selectedHouse) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($house['name_c_house']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Chọn kiểu thống kê -->
        <div class="mb-3">
            <label class="form-label">Thống kê theo:</label>
            <select id="typeSelect" class="form-select">
                <option value="week" <?= $type == 'week' ? 'selected' : '' ?>>Tuần</option>
                <option value="month" <?= $type == 'month' ? 'selected' : '' ?>>Tháng</option>
                <option value="year" <?= $type == 'year' ? 'selected' : '' ?>>Năm</option>
            </select>
        </div>

        <!-- Nút xem thống kê -->
        <div class="text-center">
            <button id="filterButton" class="btn btn-primary">Xem thống kê</button>
        </div>

        <canvas id="revenueChart" class="mt-4"></canvas>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const houseSelect = document.getElementById("houseSelect");
                const typeSelect = document.getElementById("typeSelect");
                const filterButton = document.getElementById("filterButton");

                // Khi nhấn nút "Xem thống kê"
                filterButton.addEventListener("click", function () {
                    const house = houseSelect.value;
                    const type = typeSelect.value;

                    if (!house) {
                        alert("Vui lòng chọn nhà xe.");
                        return;
                    }

                    window.location.href = `?house=${house}&type=${type}`;
                });

                // Hiển thị dữ liệu biểu đồ
                const data = <?= $chartData; ?>;
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
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    </div>
</body>
</html>
