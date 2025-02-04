<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id_trip = $_POST['id_trip'] ?? null;
$pickup_location = $_POST['pickup_location'] ?? null;
$dropoff_location = $_POST['dropoff_location'] ?? null;
$ticket_quantity = $_POST['ticket_quantity'] ?? null;
$passenger_name = $_POST['passenger_name'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$date = date('Y-m-d'); 

if (!$id_trip || !$pickup_location || !$dropoff_location || !$ticket_quantity || !$passenger_name || !$phone || !$email) {
    die("Dữ liệu không hợp lệ.");
}

// Kết nối CSDL
$db = new Database();
$conn = $db->connect();

try {
    // Lưu vé vào bảng `ticket`
    $stmt = $conn->prepare("
        INSERT INTO ticket (id_trip, id_user, number_seat, total_price, status, method, date)
        VALUES (:id_trip, :id_user, :number_seat, :total_price, 'Pending', 'Online', :date)
    ");
    $price_per_ticket = 50000; // Giá vé mẫu, bạn có thể thay đổi logic tính giá
    $total_price = $price_per_ticket * $ticket_quantity;

    $stmt->execute([
        ':id_trip' => $id_trip,
        ':id_user' => $user_id,
        ':number_seat' => $ticket_quantity,
        ':total_price' => $total_price,
        ':date' => $date,
    ]);

    echo "Đặt vé thành công!";
} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
