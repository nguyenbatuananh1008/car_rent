<?php
include 'Database.php';?>
<?php $db = new Database();
$conn = $db->connectBee();
?>
<?php
$id_ticket = $_POST['id_ticket'] ?? null;
$id_trip = $_POST['id_trip'] ?? null;
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$number_seat = $_POST['number_seat'] ?? null;
$method = $_POST['method'] ?? null;
$date = $_POST['date'] ?? null;
$total_price = $_POST['total_price'] ?? null;
$status = $_POST['status'] ?? null;
$action = $_POST['action'] ?? null;

if ($action == 'add') {
    $stmt = $conn->prepare("INSERT INTO ticket (id_trip, name, phone, number_seat, total_price, method, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("issdisss", $id_trip, $name, $phone, $number_seat, $total_price, $method, $date, $status);
        if ($stmt->execute()) {
            header('Location: ../views/ticket.php');
            exit();
        } else {
            echo "Lỗi SQL: " . $stmt->error;
        }
        $stmt->close();
    }
} elseif ($action == 'edit') {
    if ($id_ticket) {
        $stmt = $conn->prepare("UPDATE ticket SET id_trip = ?, name = ?, phone = ?, number_seat = ?, total_price = ?, method = ?, date = ?, status = ? WHERE id_ticket = ?");

        if ($stmt) {
            $stmt->bind_param("issdisssi", $id_trip, $name, $phone, $number_seat, $total_price, $method, $date, $status, $id_ticket);
            if ($stmt->execute()) {
                header('Location: ../views/ticket.php');
                exit();
            } else {
                echo "Lỗi SQL: " . $stmt->error;
            }
            $stmt->close();
        }
    }
} elseif ($action == 'delete') {
    if ($id_ticket) {
        $stmt = $conn->prepare("DELETE FROM ticket WHERE id_ticket = ?");

        if ($stmt) {
            $stmt->bind_param("i", $id_ticket);
            if ($stmt->execute()) {
                header('Location: ../views/ticket.php');
                exit();
            } else {
                echo "Lỗi SQL: " . $stmt->error;
            }
            $stmt->close();
        }
    }
} elseif ($action == 'search') {
    $search_keyword = $_POST['search_keyword'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM ticket WHERE id_trip LIKE ? OR phone LIKE ?");
    $like_keyword = '%' . $search_keyword . '%';
    if ($stmt) {
        $stmt->bind_param("ss", $like_keyword, $like_keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        echo json_encode($rows);
    } else {
        echo "Không thể thực hiện truy vấn tìm kiếm.";
    }
} else {
    echo "Hành động không hợp lệ.";
}

$conn->close();
?>