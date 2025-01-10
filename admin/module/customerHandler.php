<?php
include 'Database.php';

// Lấy danh sách khách hàng
function getCustomers($search = null) {
    $db = new Database();
    $conn = $db->connect();

    if ($search) {
        // Tìm kiếm theo id_user, name hoặc email
        $sql = "SELECT * FROM user WHERE id_user LIKE :search OR name LIKE :search OR email LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%");
    } else {
        // Lấy tất cả khách hàng
        $sql = "SELECT * FROM user";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Lấy thông tin khách hàng theo ID
function getCustomerById($id_user) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "SELECT * FROM user WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Cập nhật thông tin khách hàng
function updateCustomer($id_user, $name, $email) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE user SET name = :name, email = :email WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

    return $stmt->execute();
}

// Xóa khách hàng
function deleteCustomer($id_user) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "DELETE FROM user WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

    return $stmt->execute();
}

// Xử lý xóa khách hàng
if (isset($_GET['delete_id'])) {
    $id_user = $_GET['delete_id'];

    if (deleteCustomer($id_user)) {
        header("Location: ../views/customerList.php");
        exit();
    } else {
        echo "Xóa khách hàng thất bại!";
    }
}
// Lấy thông tin khách hàng theo ID (giống như getCustomerById)
function getCustomerById2($id_user) {
    $db = new Database(); // Tạo một đối tượng Database
    $conn = $db->connect(); // Kết nối đến cơ sở dữ liệu

    $sql = "SELECT * FROM user WHERE id_user = :id_user";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin khách hàng
}

// Lấy danh sách vé đã đặt theo ID người dùng
function getTicketsByUserId($id_user) {
    $db = new Database(); // Kết nối cơ sở dữ liệu
    $conn = $db->connect();

    $sql = "
        SELECT 
            t.id_ticket,
            t.number_seat,
            t.total_price,
            t.status,
            t.method,
            tr.id_trip,
            tr.l_pick,
            tr.l_drop,
            tr.departure_date,
            tr.price AS trip_price,
            c.c_name AS car_name,
            c.c_plate AS car_plate,
            ch.name_c_house AS car_house_name,
            ci.name_city AS city_name
        FROM ticket t
        JOIN trip tr ON t.id_trip = tr.id_trip
        JOIN car c ON tr.id_car = c.id_car
        JOIN car_house ch ON tr.id_c_house = ch.id_c_house
        JOIN city ci ON tr.id_city = ci.id_city
        WHERE t.id_user = :id_user
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách vé đã đặt
}








?>




