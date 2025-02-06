<?php
require 'database.php';
$db = new Database();
$conn = $db->connectBee();

// edit-modal
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    $sql = "SELECT id_route, id_c_house, id_city_from, id_city_to FROM route WHERE id_route = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(["error" => "Lỗi prepare: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        echo json_encode($data);    
    } else {
        echo json_encode(["error" => "Không tìm thấy dữ liệu"]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'add') {
        $id_c_house = $_POST['id_c_house'];
        $id_city_from = $_POST['id_city_from'];
        $id_city_to = $_POST['id_city_to'];
        

        $sql = "INSERT INTO route (id_c_house, id_city_from, id_city_to) 
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("iii", $id_c_house, $id_city_from, $id_city_to );
        if ($stmt->execute()) {
            header("Location: ../views/route.php");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
        exit();
    } elseif ($action === 'edit') {
        $id_route = $_POST['id_route'];
        $id_c_house  = $_POST['id_c_house'];
        $id_city_from = $_POST['id_city_from'];
        $id_city_to = $_POST['id_city_to'];
        
        $sql = "UPDATE route 
                SET id_c_house = ?, id_city_from = ?, id_city_to = ?
                WHERE id_route = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("iiii", $id_c_house, $id_city_from, $id_city_to, $id_route);
        if ($stmt->execute()) {
            header("Location: ../views/route.php");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
        exit();
    } elseif ($action === 'delete') {
        $id_route = $_POST['id_route'];
        $sql = "DELETE FROM route WHERE id_route = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_route);
        if ($stmt->execute()) {
            header("Location: ../views/route.php");
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
        exit();
    } elseif ($action === 'search') {
        $search_keyword = $_POST['search_keyword'];
        $like_keyword   = '%' . $search_keyword . '%';
        $sql = "SELECT * FROM route WHERE id_c_house LIKE ? OR id_city_from LIKE ? OR id_city_to LIKE ? OR date LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $like_keyword, $like_keyword, $like_keyword, $like_keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($row);
        exit();
    }
}

if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
