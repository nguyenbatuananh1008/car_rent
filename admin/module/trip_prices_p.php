<?php
include 'Database.php';
$db = new Database();
$conn = $db->connectBee();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'get_routes' && isset($_POST['id_c_house'])) {
        $id_c_house = $_POST['id_c_house'];
        $query = "SELECT r.id_route, c1.city_name AS city_from, c2.city_name AS city_to 
                  FROM route r
                  JOIN city c1 ON r.id_city_from = c1.id_city
                  JOIN city c2 ON r.id_city_to = c2.id_city
                  WHERE r.id_c_house = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "Lỗi truy vấn!";
            exit();
        }
        $stmt->bind_param("i", $id_c_house);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="" disabled selected>Chọn tuyến đường</option>';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id_route']}'>{$row['city_from']} → {$row['city_to']}</option>";
        }
        exit();
    }

    if ($action == 'get_cars' && isset($_POST['id_c_house'])) {
        $id_c_house = $_POST['id_c_house'];
        $query = "SELECT id_car, c_name, c_type, c_color FROM car WHERE id_c_house = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "Lỗi truy vấn!";
            exit();
        }
        $stmt->bind_param("i", $id_c_house);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="" disabled selected>Chọn xe</option>';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id_car']}'>{$row['c_name']} - {$row['c_type']} - {$row['c_color']}</option>";
        }
        exit();
    }

    if ($action == 'get_car_plate' && isset($_POST['id_car'])) {
        $id_car = $_POST['id_car'];
        $query = "SELECT c_plate FROM car WHERE id_car = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo "Lỗi truy vấn!";
            exit();
        }
        $stmt->bind_param("i", $id_car);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<option value="" disabled selected>Chọn biển số</option>';
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['c_plate']}'>{$row['c_plate']}</option>";
        }
        exit();
    }
}
?>  