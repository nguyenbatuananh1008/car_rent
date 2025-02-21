<?php
include 'Database.php';
$db = new Database();
$conn = $db->connectBee();

//  danh sách thành phố js
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['get_city'])) {
    $query_city = "SELECT id_city, city_name FROM city";
    $result_city = $conn->query($query_city);

    $options = "";
    while ($row = $result_city->fetch_assoc()) {
        $options .= "<option value='{$row['id_city']}'>{$row['city_name']}</option>";
    }
    echo $options;
    $conn->close();
    exit();
}


$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $id_route = $_POST['route_info'];
        $name_locations = $_POST['name_location'];
        $id_cities = $_POST['city_name'];
        $time_locations = $_POST['time_location'];
        $type = $_POST['type_location'];

        if (count($name_locations) !== count($time_locations) || count($name_locations) !== count($id_cities)) {
            die("Lỗi: Dữ liệu đầu vào không hợp lệ!");
        }

        $query_insert = "INSERT INTO location (id_route, name_location, id_city, time, type) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query_insert);

        foreach ($name_locations as $index => $name_location) {
            $id_city = intval($id_cities[$index]);
            $time_location = $time_locations[$index];
            
            $stmt->bind_param('isiss', $id_route, $name_location, $id_city, $time_location, $type);

            if (!$stmt->execute()) {
                die("Lỗi khi thêm: " . $stmt->error);
            }
        }
        $stmt->close();
        header('Location: ../views/location.php');
        exit();
    
    } elseif ($action === 'edit') {
        $id_location = $_POST['id_location'] ?? null;
        $id_route = $_POST['id_route'] ?? null;
        $type = $_POST['type_location'] ?? null;
        $name_location = $_POST['name_location'] ?? [];
        $id_city = $_POST['id_city'] ?? [];
        $time_location = $_POST['time_location'] ?? [];

        if (!$id_location || !$id_route) {
            die("Lỗi: Thiếu ID địa điểm hoặc ID tuyến đường.");
        }

        $query_check = "SELECT id_route FROM route WHERE id_route = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("i", $id_route);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows === 0) {
            die("Lỗi: ID tuyến đường không tồn tại!");
        }

        foreach ($name_location as $index => $name) {
            $city = $id_city[$index] ?? null;
            $time = $time_location[$index] ?? null;

            if ($city && $time) {
                $query_update = "UPDATE location SET id_route = ?, name_location = ?, id_city = ?, time = ?, type = ? WHERE id_location = ?";
                $stmt = $conn->prepare($query_update);
                $stmt->bind_param('isissi', $id_route, $name, $city, $time, $type, $id_location);

                if (!$stmt->execute()) {
                    die("Lỗi khi sửa: " . $stmt->error);
                }
            }
        }

        header('Location: ../views/location.php');
        exit();
    

    } elseif ($action === 'delete') {
        $id_location = $_POST['id_location'] ?? null;
        if ($id_location) {
            $stmt = $conn->prepare("DELETE FROM location WHERE id_location = ?");
            $stmt->bind_param("i", $id_location);
            if (!$stmt->execute()) {
                die("Lỗi khi xóa: " . $stmt->error);
            }
            header('Location: ../views/location.php');
            exit();
        } else {
            die("ID địa điểm không hợp lệ.");
        }

    } elseif ($action === 'search') {
        $search_keyword = '%' . $_POST['search_keyword'] . '%';

        $stmt = $conn->prepare("
            SELECT 
                location.id_location, 
                CONCAT(car_house.name_c_house, ' - ', city_from.city_name, ' → ', city_to.city_name) AS route_info, 
                location.name_location, 
                location.time, 
                CASE location.type 
                    WHEN 0 THEN 'Điểm đón' 
                    WHEN 1 THEN 'Điểm trả' 
                END AS type 
            FROM 
                location 
            INNER JOIN route ON location.id_route = route.id_route
            INNER JOIN car_house ON route.id_c_house = car_house.id_c_house
            INNER JOIN city AS city_from ON route.id_city_from = city_from.id_city 
            INNER JOIN city AS city_to ON route.id_city_to = city_to.id_city 
            WHERE location.name_location LIKE ?
        ");
        $stmt->bind_param("s", $search_keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        $locations = [];
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
        echo json_encode($locations);
        exit();
    }
}
$conn->close();
?>