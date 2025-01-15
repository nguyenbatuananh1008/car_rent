<?php require_once 'database.php'; ?>

<?php

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

// 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {

    $id_car = $_POST['c_plate'];
    $id_city_from = $_POST['id_city_from'];
    $id_city_to = $_POST['id_city_to'];
    $t_pick = $_POST['t_pick'];
    $t_drop = $_POST['t_drop'];
    $date = $_POST['date'];
    $price = $_POST['price'];

    $sql = "INSERT INTO trip (id_car, id_city_from, id_city_to, t_pick, t_drop, date, price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            'iiisssd',
            $id_car,
            $id_city_from,
            $id_city_to,
            $t_pick,
            $t_drop,
            $date,
            $price
        );
        if ($stmt->execute()) {
            header("Location: ../views/trip.php");
            exit();
        } else {
            echo "Lỗi khi thêm chuyến xe: " . $stmt->error;
        }

        // 
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
            $id_trip = $_GET['id'];
            $query = "SELECT 
                t.*, 
                c.id_c_house,
                c.id_car
              FROM trip t
              JOIN car c ON t.id_car = c.id_car
              WHERE t.id_trip = ?";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_trip);
            $stmt->execute();
            $result = $stmt->get_result();
            $trip_data = $result->fetch_assoc();

            echo json_encode($trip_data);
            exit();

        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
            $id_trip = $_POST['id_trip'];
            $id_car = $_POST['c_plate'];
            $id_city_from = $_POST['id_city_from'];
            $id_city_to = $_POST['id_city_to'];
            $t_pick = $_POST['t_pick'];
            $t_drop = $_POST['t_drop'];
            $date = $_POST['date'];
            $price = $_POST['price'];

            $sql = "UPDATE trip 
            SET id_car = ?,
                id_city_from = ?,
                id_city_to = ?,
                t_pick = ?,
                t_drop = ?,
                date = ?,
                price = ?
            WHERE id_trip = ?";

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param(
                    "iiisssdi",
                    $id_car,
                    $id_city_from,
                    $id_city_to,
                    $t_pick,
                    $t_drop,
                    $date,
                    $price,
                    $id_trip
                );

                if ($stmt->execute()) {
                    header("Location: ../views/trip.php");
                    exit();
                } else {
                    echo "Lỗi khi cập nhật chuyến xe: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Lỗi chuẩn bị câu lệnh SQL: " . $conn->error;
            }
        }
    } elseif ($action == 'search') {
        $search_keyword = $_POST['search_keyword'];
        $stmt = $conn->prepare("SELECT * FROM trip WHERE name_c_house LIKE ? OR address LIKE ? OR phone LIKE ? OR email LIKE ?");
        $like_keyword = '%' . $search_keyword . '%';
        $stmt->bind_param("ssss", $like_keyword, $like_keyword, $like_keyword, $like_keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        }
    }
}

$stmt->close();
?>