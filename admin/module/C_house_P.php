<?php
require 'database.php';?>

<?php $db = new Database();
$conn = $db->connectBee();
?>
<?php
$name_c_house = $_POST['name_c_house'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$action = $_POST['action'];

if ($action == 'add') {
    $stmt = $conn->prepare("INSERT INTO car_house (name_c_house, address, phone, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $name_c_house, $address, $phone, $email);
    if ($stmt->execute()) {
        header('Location: ../views/C_house.php');
        exit();
    } else {
        echo "Lỗi: " . $stmt->error;
    }

} elseif ($action == 'edit') {
    $id_c_house = $_POST['id_c_house'];
    $stmt = $conn->prepare("UPDATE car_house SET name_c_house = ?, address = ?, phone = ?, email = ? WHERE id_c_house = ?");
    $stmt->bind_param("ssssi", $name_c_house, $address, $phone, $email, $id_c_house);
    $stmt->execute();

} elseif ($action == 'delete') {
    $id_c_house = $_POST['id_c_house'];
    $stmt = $conn->prepare("DELETE FROM car_house WHERE id_c_house = ?");
    $stmt->bind_param("i", $id_c_house);
    $stmt->execute();

} elseif ($action == 'search') {
    $search_keyword = $_POST['search_keyword'];
    $stmt = $conn->prepare("SELECT * FROM car_house WHERE name_c_house LIKE ? OR address LIKE ? OR phone LIKE ? OR email LIKE ?");
    $like_keyword = '%' . $search_keyword . '%';
    $stmt->bind_param("ssss", $like_keyword, $like_keyword, $like_keyword, $like_keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    }
}

if ($stmt->execute()) {
    echo "Thành công!";
    header('Location: ../views/C_house.php');
    exit();
} else {
    echo "Lỗi: " . $stmt->error;
}   

$stmt->close();
$conn->close();
?>
