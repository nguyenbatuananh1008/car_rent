<?php require 'database.php'; ?>
<?php $db = new Database();
$conn = $db->connectBee();
?>
<?php require 'uploads.php'; ?>

<?php
$c_name = $_POST['c_name'] ?? null;
$c_plate = $_POST['c_plate'] ?? null;
$id_c_house = $_POST['id_c_house'] ?? null;
$capacity = $_POST['capacity'] ?? null;
$action = $_POST['action'] ?? null;

if ($action == 'add') {
    $stmt = $conn->prepare("INSERT INTO car (c_name, c_plate, id_c_house, capacity, img) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiis", $c_name, $c_plate, $id_c_house, $capacity, $img);

    if ($stmt->execute()) {
        header('Location: ../views/Car.php');
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }

} elseif ($action == 'edit') {
    $id_car = $_POST['id_car'];
    $query = "UPDATE car SET c_name = ?, c_plate = ?, id_c_house = ?, capacity = ?";
    $types = "ssii";
    $params = [&$c_name, &$c_plate, &$id_c_house, &$capacity];

    if ($img !== null) {
        $query .= ", img = ?";
        $types .= "s";
        $params[] = &$img;
    }
    $query .= " WHERE id_car = ?";
    $types .= "i";
    $params[] = &$id_car;

    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header('Location: ../views/Car.php');
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }

} elseif ($action == 'delete') {
    $id_car = $_POST['id_car'];
    $stmt = $conn->prepare("SELECT img FROM car WHERE id_car = ?");
    $stmt->bind_param("i", $id_car);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if (file_exists('../uploads/' . $row['img'])) {
        unlink('../uploads/' . $row['img']);
    }

    $stmt = $conn->prepare("DELETE FROM car WHERE id_car = ?");
    $stmt->bind_param("i", $id_car);

    if ($stmt->execute()) {
    } else {
        echo "Lỗi: " . $stmt->error;
    }

} elseif ($action == 'search') {
    $search_keyword = $_POST['search_keyword'];
    $like_keyword = '%' . $search_keyword . '%';
    $sql = "SELECT car.*, car_house.name_c_house FROM car JOIN car_house ON car.id_c_house = car_house.id_c_house 
            WHERE car.c_name LIKE ? 
               OR car.capacity LIKE ? 
               OR car.c_plate LIKE ? 
               OR car_house.name_c_house LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $like_keyword, $like_keyword, $like_keyword, $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
        echo json_encode($rows);
    }
}
header('Location: ../views/Car.php');
exit();
$stmt->close();
$conn->close();
?>
