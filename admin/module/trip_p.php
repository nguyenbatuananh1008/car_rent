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

    if ($action == 'add') {
        $id_route = $_POST['id_route'];
        $id_c_house = $_POST['id_c_house'];
        $id_car = $_POST['id_car'];
        $t_pick = $_POST['t_pick'];
        $t_drop = $_POST['t_drop'];
        $t_limit = $_POST['t_limit'];
        $price = $_POST['price'];

        if ($id_route && $id_c_house && $id_car && $t_pick && $t_drop && $t_limit > 0 && $price > 0) {
            $query = "INSERT INTO trip (id_route, id_c_house, id_car, t_pick, t_drop, t_limit, price) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                echo json_encode(['status' => 'error', 'message' => 'Lỗi khi chuẩn bị truy vấn!']);
                exit();
            }
            $stmt->bind_param("iiissid", $id_route, $id_c_house, $id_car, $t_pick, $t_drop, $t_limit, $price);
            if ($stmt->execute()) {
                header("Location: ../views/trip.php?error=db");
                exit();
            }
        }
    }

    if ($action === 'edit') {
        $id_trip = $_POST['id_trip'];
        $id_route = $_POST['id_route'];
        $id_c_house = $_POST['id_c_house'];
        $id_car = $_POST['id_car'];
        $t_pick = $_POST['t_pick'];
        $t_drop = $_POST['t_drop'];
        $t_limit = $_POST['t_limit'];
        $price = $_POST['price'];

        $query = "UPDATE trip SET id_route = ?, id_c_house = ?, id_car = ?, t_pick = ?, t_drop = ?, t_limit = ?, price = ? WHERE id_trip = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi chuẩn bị truy vấn!']);
            exit();
        }
        $stmt->bind_param("iiissidi", $id_route, $id_c_house, $id_car, $t_pick, $t_drop, $t_limit, $price, $id_trip);
        if ($stmt->execute()) {
            header("Location: ../views/trip.php?error=db");
            exit();
        }
    }

    if ($action === 'delete') {
        $id_trip = $_POST['id_trip'];
        $sql = "DELETE FROM trip WHERE id_trip = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi chuẩn bị truy vấn!']);
            exit();
        }
        $stmt->bind_param("i", $id_trip);
        if ($stmt->execute()) {
            header("Location: ../views/trip.php?");
            exit();
        }
    }

    if ($action === 'search' && isset($_POST['search_keyword'])) {
        $searchKeyword = $_POST['search_keyword'];
        $query = "SELECT t.id_trip, ch.name_c_house, r.id_route, c.id_car, c.c_plate,
                         cf.city_name AS city_from, ct.city_name AS city_to, 
                         c.c_name, c.c_type, c.c_color, 
                         t.t_pick, t.t_drop, t.t_limit, t.price
                  FROM trip t
                  JOIN car_house ch ON t.id_c_house = ch.id_c_house
                  JOIN route r ON t.id_route = r.id_route
                  JOIN city cf ON r.id_city_from = cf.id_city
                  JOIN city ct ON r.id_city_to = ct.id_city
                  JOIN car c ON t.id_car = c.id_car
                  WHERE ch.name_c_house LIKE ? OR t.id_trip = ?";
        $stmt = $conn->prepare($query);
        $like_keyword = "%$searchKeyword%";
        $stmt->bind_param("si", $like_keyword, $searchKeyword);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_trip = $_GET['id'];
    $query = "SELECT * FROM trip WHERE id_trip = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi khi chuẩn bị truy vấn!']);
        exit();
    }
    $stmt->bind_param("i", $id_trip);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());
    exit();
}

?>
