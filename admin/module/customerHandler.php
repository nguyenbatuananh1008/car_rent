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
// Hàm tìm kiếm khách hàng






?>




