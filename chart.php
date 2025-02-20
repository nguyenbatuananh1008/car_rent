<?php
// Kết nối cơ sở dữ liệu
$host = 'localhost'; // Thay đổi với host của bạn
$dbname = 'dat_ve'; // Thay đổi với tên cơ sở dữ liệu của bạn
$username = 'root'; // Thay đổi với tên người dùng của bạn
$password = ''; // Thay đổi với mật khẩu của bạn

try {
    // Kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn SQL
    $sql = "SELECT 
                DATE_FORMAT(date, '%Y-%m') AS month, 
                SUM(total_price) AS total_revenue
            FROM 
                ticket
            GROUP BY 
                DATE_FORMAT(date, '%Y-%m')
            ORDER BY 
                month";

    // Thực thi truy vấn và lấy kết quả
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu theo tháng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS cho biểu đồ cột */
        .bar {
            display: inline-block;
            width: 50px; /* Chiều rộng của mỗi cột */
            margin: 0 5px;
            background-color: rgba(54, 162, 235, 0.6); /* Màu cột */
            text-align: center;
            color: white;
            border-radius: 5px;
            position: relative;
        }
        .bar span {
            position: absolute;
            bottom: -20px;
            width: 100%;
            text-align: center;
        }
        .chart-container {
            display: flex;
            justify-content: space-evenly;
            align-items: flex-end;
            height: 300px; /* Chiều cao của biểu đồ */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Thống kê doanh thu theo tháng</h1>

        <div class="chart-container">
            <?php
            $maxRevenue = max(array_column($results, 'total_revenue')); // Lấy giá trị doanh thu cao nhất để tính tỷ lệ
            foreach ($results as $row) {
                $height = ($row['total_revenue'] / $maxRevenue) * 100; // Tính chiều cao cột tương ứng với doanh thu
                echo "<div class='bar' style='height: {$height}%;'>
                        <span>{$row['month']}</span>
                        <div>" . number_format($row['total_revenue'], 0, ',', '.') . " VND</div>
                    </div>";
            }
            ?>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Quay lại trang chủ</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
