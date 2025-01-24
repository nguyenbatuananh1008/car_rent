<?php require 'database.php'; ?>
<?php $db = new Database();
$conn = $db->connectBee();
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['id_c_house'])) {
        $id_c_house = $_POST['id_c_house'];
        $query = "SELECT id_car, c_plate FROM car WHERE id_c_house = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_c_house);
        $stmt->execute();
        $result = $stmt->get_result();

        $c_plate = [];
        while ($row = $result->fetch_assoc()) {
            $c_plate[] = $row;
        }
        echo json_encode($c_plate);
        exit();
    }


    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'add') {
        $id_car = $_POST['c_plate'];
        $id_city_from = $_POST['id_city_from'];
        $id_city_to = $_POST['id_city_to'];
        $t_pick = $_POST['t_pick'];
        $t_drop = $_POST['t_drop'];
        $t_limit = $_POST['t_limit'];

        $price = $_POST['price'];

        $sql = "INSERT INTO trip (id_car, id_city_from, id_city_to, t_pick, t_drop, t_limit,  price) 
                VALUES (?, ?, ?, ?, ?, ?,  ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissii", $id_car, $id_city_from, $id_city_to, $t_pick, $t_drop, $t_limit, $price);
        if ($stmt->execute()) {
            header("Location: ../views/trip.php");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
        exit();
    } elseif ($action === 'edit') {
        $id_trip = $_POST['id_trip'];
        $id_car = $_POST['c_plate'];
        $id_city_from = $_POST['id_city_from'];
        $id_city_to = $_POST['id_city_to'];
        $t_pick = $_POST['t_pick'];
        $t_drop = $_POST['t_drop'];
        $t_limit = $_POST['t_limit'];
        $price = $_POST['price'];

        $sql = "UPDATE trip 
                SET id_car = ?, id_city_from = ?, id_city_to = ?, t_pick = ?, t_drop = ?, t_limit = ?,  price = ? 
                WHERE id_trip = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiissisi", $id_car, $id_city_from, $id_city_to, $t_pick, $t_drop, $t_limit,  $price, $id_trip);
        if ($stmt->execute()) {
            header("Location: ../views/trip.php");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
        exit();
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
    } elseif ($action === 'search') {
        $search_keyword = $_POST['search_keyword'];
        $like_keyword = '%' . $search_keyword . '%';
        $sql = "SELECT * FROM trip WHERE id_car LIKE ? OR id_city_from LIKE ? OR id_city_to LIKE ? OR t_limit LIKE ? OR date LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $like_keyword, $like_keyword, $like_keyword, $like_keyword, $like_keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($row);
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {

    $id_trip = $_GET['id'];
    $sql = "SELECT t.*, c.id_c_house, c.id_car 
            FROM trip t 
            JOIN car c ON t.id_car = c.id_car 
            WHERE t.id_trip = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_trip);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode($row);
    exit();
}

if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
