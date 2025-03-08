<?php
include 'Database.php';
$db = new Database();
$conn = $db->connectBee();

// Get trip price details for edit modal
if (isset($_GET['action']) && $_GET['action'] === 'get_trip_price' && isset($_GET['id_price'])) {
    $id_price = $_GET['id_price'];
    $query = "SELECT tp.id_price, tp.id_city_from AS l_start, tp.id_city_to AS l_stop, tp.base_price AS price, t.id_route
              FROM trip_prices tp
              JOIN trip t ON tp.id_trip = t.id_trip
              WHERE tp.id_price = ?";
    $stmt = $conn->prepare($query) or handleDbError($conn);
    $stmt->bind_param("i", $id_price);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        exit(json_encode($row));
    } else {
        exit(json_encode(['status' => 'error', 'message' => 'Record not found']));
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) {
    exit(json_encode(['status' => 'error', 'message' => 'Invalid request method or action not set']));
}

$action = $_POST['action'];
function handleDbError($stmt) {
    exit(json_encode(['status' => 'error', 'message' => 'Database query error: ' . $stmt->error]));
}

// Get routes
if ($action === 'get_routes' && isset($_POST['id_c_house'])) {
    $id_c_house = $_POST['id_c_house'];
    $query = "SELECT r.id_route, c1.city_name AS city_from, c2.city_name AS city_to 
              FROM route r
              JOIN city c1 ON r.id_city_from = c1.id_city
              JOIN city c2 ON r.id_city_to = c2.id_city
              WHERE r.id_c_house = ?";
    
    $stmt = $conn->prepare($query) or handleDbError($conn);
    $stmt->bind_param("i", $id_c_house);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" disabled selected>Chọn tuyến đường</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id_route']}'>{$row['city_from']} → {$row['city_to']}</option>";
    }
    exit();
}

// Get cars
if ($action === 'get_cars' && isset($_POST['id_c_house'])) {
    $id_c_house = $_POST['id_c_house'];
    $query = "SELECT id_car, c_name, c_type, c_color FROM car WHERE id_c_house = ?";
    
    $stmt = $conn->prepare($query) or handleDbError($conn);
    $stmt->bind_param("i", $id_c_house);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" disabled selected>Chọn xe</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id_car']}'>{$row['c_name']} - {$row['c_type']} - {$row['c_color']}</option>";
    }
    exit();
}

// Get car plate
if ($action === 'get_car_plate' && isset($_POST['id_car'])) {
    $id_car = $_POST['id_car'];
    $query = "SELECT c_plate FROM car WHERE id_car = ?";
    
    $stmt = $conn->prepare($query) or handleDbError($conn);
    $stmt->bind_param("i", $id_car);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" disabled selected>Chọn biển số</option>';
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['c_plate']}'>{$row['c_plate']}</option>";
    }
    exit();
}

// Get cities by route
if ($action === 'get_cities_by_route' && isset($_POST['id_route'])) {
    $id_route = $_POST['id_route'];
    $query = "SELECT c.id_city, c.city_name 
              FROM city c
              WHERE c.id_city IN (
                  SELECT r.id_city_from FROM route r WHERE r.id_route = ?
                  UNION
                  SELECT r.id_city_to FROM route r WHERE r.id_route = ?
                  UNION
                  SELECT rs.id_city FROM route_stop rs WHERE rs.id_route = ?
              )";
    
    $stmt = $conn->prepare($query) or handleDbError($conn);
    $stmt->bind_param("iii", $id_route, $id_route, $id_route);
    $stmt->execute();
    $result = $stmt->get_result();

    $cities = [];
    while ($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
    exit(json_encode($cities));
}

// Add trip price
if ($action === 'add') {
    $required = ['id_route', 'id_c_house', 'id_car', 'l_start', 'l_stop', 'price'];
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            exit(json_encode(['status' => 'error', 'message' => 'Missing required fields']));
        }
    }

    $id_route = $_POST['id_route'];
    $l_start = $_POST['l_start'];
    $l_stop = $_POST['l_stop'];
    $price = $_POST['price'];

    $query_trip = "SELECT id_trip FROM trip WHERE id_route = ?";
    $stmt_trip = $conn->prepare($query_trip) or handleDbError($conn);
    $stmt_trip->bind_param("i", $id_route);
    $stmt_trip->execute();
    $result_trip = $stmt_trip->get_result();
    
    if ($row_trip = $result_trip->fetch_assoc()) {
        $id_trip = $row_trip['id_trip'];
        $query = "INSERT INTO trip_prices (id_trip, id_city_from, id_city_to, base_price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query) or handleDbError($conn);
        $stmt->bind_param("iiid", $id_trip, $l_start, $l_stop, $price);
        
        if ($stmt->execute()) {
            header("Location: ../views/trip_prices.php?success=add");
            exit();
        }
    }
    exit(json_encode(['status' => 'error', 'message' => 'Failed to add trip price']));
}

// Delete trip price
if ($action === 'delete' && isset($_POST['id_price'])) {
    $id_price = $_POST['id_price'];
    $query = "DELETE FROM trip_prices WHERE id_price = ?";
    $stmt = $conn->prepare($query) or handleDbError($conn);
    $stmt->bind_param("i", $id_price);
    
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        header("Location: ../views/trip_prices.php?success=delete");
        exit();
    }
    exit(json_encode(['status' => 'error', 'message' => 'Failed to delete trip price']));
}


if ($_POST['action'] == 'edit') {

    $id_price = $_POST['id_price'];
    $l_start  = $_POST['l_start'];
    $l_stop   = $_POST['l_stop'];
    $price    = $_POST['price'];

    $updateQuery = "UPDATE trip_prices SET id_city_from = ?, id_city_to = ?, base_price = ? WHERE id_price = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssii", $l_start, $l_stop, $price, $id_price);
    if($stmt->execute()){
        header("Location: ../views/trip_prices.php?success=edit");
        exit();
    } else {
  
    }
}

?>