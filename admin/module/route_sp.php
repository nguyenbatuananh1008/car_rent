<?php
require 'database.php';
$db = new Database();
$conn = $db->connectBee();

if (isset($_GET['get_city'])) {
    $query_city = "SELECT id_city, city_name FROM city";
    $result_city = $conn->query($query_city);
    $city_list = [];
    while ($row_city = $result_city->fetch_assoc()) {
        $city_list[] = [
            'value' => $row_city['city_name'],
            'id' => $row_city['id_city']
        ];
    }
    echo json_encode($city_list);
    exit();
}

if ($_POST['action'] == 'add') {
    $route_info = $_POST['route_info']; 
    $route_stop = $_POST['route_stop']; 
    $number_stop = $_POST['number_stop']; 

    // Lấy thông tin tuyến đường từ database
    $query_route = "SELECT id_route, id_c_house, id_city_from, id_city_to FROM route WHERE id_route = ?";
    $stmt = $conn->prepare($query_route);
    $stmt->bind_param("i", $route_info);
    $stmt->execute();
    $result_route = $stmt->get_result();
    $route_details = $result_route->fetch_assoc();
    $id_c_house = $route_details['id_c_house'];
    $id_city_from = $route_details['id_city_from'];
    $id_city_to = $route_details['id_city_to'];
    
    $conn->begin_transaction();

    try {
        // Thêm từng điểm dừng
        foreach ($route_stop as $index => $city_name) {
            // Lấy id_city từ tên thành phố
            $query_city = "SELECT id_city FROM city WHERE city_name = ?";
            $stmt_city = $conn->prepare($query_city);
            $stmt_city->bind_param("s", $city_name);
            $stmt_city->execute();
            $result_city = $stmt_city->get_result();

            if ($result_city->num_rows == 0) {
                throw new Exception("Thành phố '$city_name' không tồn tại trong CSDL.");
            }

            $city = $result_city->fetch_assoc();
            $id_city = $city['id_city'];

            // Kiểm tra xem thành phố đã có trong tuyến đường này chưa
            $query_check = "SELECT id_route_stop FROM route_stop WHERE id_route = ? AND id_city = ?";
            $stmt_check = $conn->prepare($query_check);
            $stmt_check->bind_param("ii", $route_info, $id_city);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                throw new Exception("Thành phố '$city_name' đã tồn tại trong tuyến đường này.");
            }

            // Thêm điểm dừng vào bảng route_stop
            $query_insert_stop = "INSERT INTO route_stop (id_route, id_city, type) VALUES (?, ?, ?)";
            $stmt_stop = $conn->prepare($query_insert_stop);
            $stmt_stop->bind_param("iii", $route_info, $id_city, $number_stop[$index]);
            $stmt_stop->execute();
        }

        $conn->commit();
        header("Location: ../views/route_stop.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $stmt->close();
    exit();
} else if ($_POST['action'] == 'delete') {
    $id_route = $_POST['id_route'];
    if (empty($id_route)) {
        echo json_encode(['status' => 'error', 'message' => 'ID tuyến đường không hợp lệ.']);
        exit();
    }
    $query_delete = "DELETE FROM route_stop WHERE id_route = ?";
    $stmt = $conn->prepare($query_delete);
    $stmt->bind_param("i", $id_route);

    if ($stmt->execute()) {
        header("Location: ../views/route_stop.php");
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Lỗi khi xóa điểm dừng.']);
    }
    $stmt->close();
    exit();
}
?>
