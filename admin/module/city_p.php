<?php require 'database.php'; ?>
<?php $db = new Database();
$conn = $db->connectBee();
?>
<?php
$city_name = $_POST['city_name'] ?? null;
$action = $_POST['action'] ?? null;


if ($action == "add" ){
    $stmt = $conn->prepare("INSERT INTO city (city_name) VALUES (?)");
    $stmt->bind_param("s", $city_name);  

    if ($stmt->execute()) {
        header('Location: ../views/City.php');
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

elseif ($action == "edit") {
    $id_city = $_POST['id_city'];
    $stmt = $conn->prepare("UPDATE city SET city_name = ? WHERE id_city = ?");
    $stmt->bind_param("si", $city_name, $id_city);
    $stmt->execute();
}

elseif ($action == "delete") {
    $id_city = $_POST['id_city'];
    $stmt = $conn->prepare("DELETE FROM city WHERE id_city = ?");
    $stmt->bind_param("i", $id_city);
    $stmt->execute();
}

elseif ($action == "search") {
    $search_keyword = $_POST['search_keyword'];
    $stmt = $conn->prepare("SELECT * FROM city WHERE city_name LIKE ?");
    $like_keyword = '%' . $search_keyword . '%';
    $stmt->bind_param("s", $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    }
}

if ($stmt->execute()) {
    echo "Thành công!";
    header('Location: ../views/City.php');
    exit();
} else {
    echo "Lỗi: " . $stmt->error;
}   
$stmt->close();
$conn->close();
?>