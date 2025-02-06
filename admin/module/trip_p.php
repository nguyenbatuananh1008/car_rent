<?php
include 'Database.php';
$db = new Database();
$conn = $db->connectBee();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Lấy tuyến đường theo nhà xe
    if ($action == 'get_routes' && isset($_POST['id_c_house'])) {
        $id_c_house = $_POST['id_c_house'];

        $query = "SELECT r.id_route, c1.city_name AS city_from, c2.city_name AS city_to 
                  FROM route r
                  JOIN city c1 ON r.id_city_from = c1.id_city
                  JOIN city c2 ON r.id_city_to = c2.id_city
                  WHERE r.id_c_house = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_c_house);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="" disabled selected>Chọn tuyến đường</option>';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id_route']}'>{$row['city_from']} → {$row['city_to']}</option>";
        }
    }

    // Lấy thông tin xe theo nhà xe
    if ($action == 'get_cars' && isset($_POST['id_c_house'])) {
        $id_c_house = $_POST['id_c_house'];

        $query = "SELECT id_car, c_name, c_type, c_color FROM car WHERE id_c_house = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_c_house);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="" disabled selected>Chọn xe</option>';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id_car']}'>{$row['c_name']} - {$row['c_type']} - {$row['c_color']}</option>";
        }
    }

    // Lấy biển số xe theo xe đã chọn
    if ($action == 'get_car_plate' && isset($_POST['id_car'])) {
        $id_car = $_POST['id_car'];

        $query = "SELECT c_plate FROM car WHERE id_car = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_car);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="" disabled selected>Chọn biển số</option>';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['c_plate']}'>{$row['c_plate']}</option>";
        }
    }

    if ($action == 'add') {
        
        $id_route = $_POST['id_route'];
        $id_c_house = $_POST['id_c_house']; 
        $id_car = $_POST['id_car']; 
        $t_pick = $_POST['t_pick'];
        $t_drop = $_POST['t_drop'];
        $t_limit = $_POST['t_limit'];
        $price = $_POST['price'];

        // Kiểm tra dữ liệu 
        if ($id_route && $id_c_house && $id_car && $t_pick && $t_drop && $t_limit > 0 && $price > 0) {

            $query = "INSERT INTO trip (id_route, id_c_house, id_car, t_pick, t_drop, t_limit, price) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiissid", $id_route, $id_c_house, $id_car, $t_pick, $t_drop, $t_limit, $price);

            if ($stmt->execute()) {
                echo "Thêm chuyến xe thành công!";
                header("Location: ../views/trip.php");
                exit();
            } else {
                echo "Lỗi khi thêm chuyến xe!";
            }
        } else {
                echo "Dữ liệu không hợp lệ!";
            }

        } elseif ($action === 'delete') {

            $id_trip = $_POST['id_trip'];
            $sql = "DELETE FROM trip WHERE id_trip = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_trip);
            if ($stmt->execute()) {
                header("Location: ../views/trip.php");
                exit(); 
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }
            $stmt->close();
            exit();
    }
}
?>
