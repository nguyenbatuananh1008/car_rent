<?php include 'database.php'; ?>

<?php
$c_name = $_POST['c_name'] ?? null;
$c_plate = $_POST['c_plate'] ?? null;
$id_c_house = $_POST['id_c_house'] ?? null;
$capacity = $_POST['capacity'] ?? null;
$action = $_POST['action'] ?? null;

// Xử lý upload ảnh
$img = null;
if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {

    // Tạo tên file duy nhất bằng thời gian hiện tại
    $img_name = time() . '_' . basename($_FILES['img']['name']);
    $img_path = '../uploads/' . $img_name;

    // Tạo thư mục nếu chưa có
    if (!is_dir('../uploads/')) {
        mkdir('../uploads/', 0777, true);
    }

    // Di chuyển file từ thư mục tạm đến thư mục uploads
    if (move_uploaded_file($_FILES['img']['tmp_name'], $img_path)) {
        $img = $img_name;
    }
}

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
    // Xóa ảnh nếu tồn tại
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
    $stmt = $conn->prepare("SELECT * FROM car WHERE c_name LIKE ? OR c_plate LIKE ?");
    $like_keyword = '%' . $search_keyword . '%';
    $stmt->bind_param("ss", $like_keyword, $like_keyword);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
header('Location: ../views/Car.php');
exit();

$stmt->close();
$conn->close();
?>
