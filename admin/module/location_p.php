<?php
include 'Database.php';
?>
<?php $db = new Database();
$conn = $db->connectBee();
?>
<?php
$action = $_POST['action'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $id_trip = $_POST['trip_info'];
        $name_locations = $_POST['name_location'];
        $time_locations = $_POST['time_location'];
        $type = $_POST['type_location'];

        if (count($name_locations) !== count($time_locations)) {
            echo "Lỗi: Số lượng tên vị trí và thời gian không khớp!";
            exit();
        }

        $query_insert = "INSERT INTO location (id_trip, name_location, time, type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query_insert);

        // Lặp qua các vị trí và thời gian để thêm vào cơ sở dữ liệu
        for ($i = 0; $i < count($name_locations); $i++) {
            $name_location = $name_locations[$i];
            $time_location = $time_locations[$i];

            $stmt->bind_param('issi', $id_trip, $name_location, $time_location, $type);
            if (!$stmt->execute()) {
                echo "Lỗi khi thêm: " . $conn->error;
                $stmt->close();
                exit();
            }
        }

        $stmt->close();
        header('Location: ../views/location.php');
        exit();
    } elseif ($action === 'edit') {

        $id_location = $_POST['id_location'] ?? null;
        $id_trip = $_POST['id_trip'];
        $name_location = $_POST['name_location'];
        $time = $_POST['time'];
        $type = $_POST['type_location'];

        if ($id_location) {
            $query_update = "UPDATE location SET id_trip = ?, name_location = ?, time = ?, type = ? WHERE id_location = ?";
            $stmt = $conn->prepare($query_update);
            $stmt->bind_param('issii', $id_trip, $name_location, $time, $type, $id_location);
            var_dump($id_trip, $name_location, $time, $type, $id_location);
            if ($stmt->execute()) {
                echo "Sửa thành công!";
                header('Location: ../views/location.php');
                exit();
            } else {
                echo "Lỗi khi sửa: " . $conn->error;
            }
            $stmt->close();
        } else {
            echo "ID địa điểm không hợp lệ.";
        }
    } elseif ($action === 'delete') {

        $id_location = $_POST['id_location'] ?? null;
        if ($id_location) {
            $stmt = $conn->prepare("DELETE FROM location WHERE id_location = ?");
            $stmt->bind_param("i", $id_location);

            if ($stmt->execute()) {
                header('Location: ../views/location.php');
                exit();
            } else {
                echo "Lỗi khi xóa: " . $conn->error;
            }
            $stmt->close();
        } else {
            echo "ID địa điểm không hợp lệ.";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_location'])) {
    $id_location = $_GET['id_location'];
    $query = "
        SELECT 
            location.id_location,
            location.id_trip,
            location.name_location,
            location.time,
            location.type AS type_location,
            CONCAT(car_house.name_c_house, ' - ', car.c_plate, ' - ', city_from.city_name, ' → ', city_to.city_name) AS trip_info
        FROM 
            location
        INNER JOIN trip ON location.id_trip = trip.id_trip
        INNER JOIN car ON trip.id_car = car.id_car
        INNER JOIN car_house ON car.id_c_house = car_house.id_c_house
        INNER JOIN city AS city_from ON trip.id_city_from = city_from.id_city
        INNER JOIN city AS city_to ON trip.id_city_to = city_to.id_city
        WHERE 
            location.id_location = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_location);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Không tìm thấy địa điểm.']);
    }
    $stmt->close();
} elseif ($action === 'search') {
    $search_keyword = $_POST['search_keyword'];
    $stmt = $conn->prepare("
        SELECT 
            location.id_location, 
            CONCAT(car_house.name_c_house, ' - ', car.c_plate, ' - ', city_from.city_name, ' → ', city_to.city_name) AS trip_info, 
            location.name_location, 
            location.time, 
            CASE location.type 
                WHEN 0 THEN 'Điểm đón' 
                WHEN 1 THEN 'Điểm trả' 
            END AS type 
        FROM 
            location 
        INNER JOIN 
            trip ON location.id_trip = trip.id_trip 
        INNER JOIN 
            car ON trip.id_car = car.id_car 
        INNER JOIN 
            car_house ON car.id_c_house = car_house.id_c_house 
        INNER JOIN 
            city AS city_from ON trip.id_city_from = city_from.id_city 
        INNER JOIN 
            city AS city_to ON trip.id_city_to = city_to.id_city 
        WHERE 
            location.name_location LIKE ?
    ");
    $like_keyword = '%' . $search_keyword . '%';
    $stmt->bind_param("s", $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    }
}

$conn->close();
?>

