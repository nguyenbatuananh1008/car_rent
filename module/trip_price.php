<?php
require_once 'TripSearcher.php';
$tripSearcher = new TripSearcher();

if (isset($_GET['pickup_city_id'], $_GET['dropoff_city_id'], $_GET['trip_id'])) {
    $pickup_city_id = $_GET['pickup_city_id'];
    $dropoff_city_id = $_GET['dropoff_city_id'];
    $trip_id = $_GET['trip_id'];

    // Hàm tính giá
    $result = $tripSearcher->getTripPrice($trip_id, $pickup_city_id, $dropoff_city_id);

    // Kiểm tra và trả về giá theo yêu cầu
    if (isset($result['price'])) {
        if (is_numeric($result['price'])) {
            // Nếu là giá hợp lệ, trả về giá
            echo json_encode(['success' => true, 'price' => $result['price']]);
        } else {
            // Nếu không phải giá mà là thông báo lỗi (trùng thành phố hoặc lỗi khác)
            echo json_encode(['success' => false, 'message' => $result['price']]);
        }
    } else {
        // Trường hợp không tìm thấy giá
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy giá cho lộ trình này.']);
    }
}
?>
