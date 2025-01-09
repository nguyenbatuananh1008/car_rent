<?php
include 'Database.php';

// Lấy thông tin admin từ cơ sở dữ liệu
function getAdminInfo($id_admin) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "SELECT * FROM admin WHERE id_admin = :id_admin";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}



// Cập nhật thông tin admin
function updateAdminInfo($id_admin, $name = null, $password = null) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE admin SET ";
    $params = [];
    if ($name !== null) {
        $sql .= "name = :name, ";
        $params[':name'] = $name;
    }
    if ($password !== null) {
        $sql .= "password = :password, ";
        $params[':password'] = $password;
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE id_admin = :id_admin";

    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindParam(':id_admin', $id_admin, PDO::PARAM_INT);

    return $stmt->execute();
}


// Lấy danh sách nhân viên (usertype = 0)
// Lấy danh sách nhân viên (hỗ trợ tìm kiếm)
function getStaffList($search = null) {
    $db = new Database();
    $conn = $db->connect();

    if ($search) {
        // Tìm kiếm theo id_admin, name hoặc email
        $sql = "SELECT * FROM admin WHERE usertype = 0 AND (id_admin LIKE :search OR name LIKE :search OR email LIKE :search)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        // Lấy toàn bộ danh sách nhân viên
        $sql = "SELECT * FROM admin WHERE usertype = 0";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// Thêm nhân viên mới
function addStaff($name, $email, $password, $usertype) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "INSERT INTO admin (name, email, password, usertype) VALUES (:name, :email, :password, :usertype)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':usertype', $usertype, PDO::PARAM_INT);

    return $stmt->execute();
}

// Lấy thông tin nhân viên theo ID
function getStaffById($id) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "SELECT * FROM admin WHERE id_admin = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Cập nhật thông tin nhân viên
function updateStaff($id, $name, $email, $password, $usertype) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE admin SET name = :name, email = :email, password = :password, usertype = :usertype WHERE id_admin = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':usertype', $usertype, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

// Xóa nhân viên
function deleteUser($id) {
    $db = new Database();
    $conn = $db->connect();

    // Kiểm tra xem nhân viên có tồn tại và là loại tài khoản nhân viên (usertype = 0)
    $checkSql = "SELECT * FROM admin WHERE id_admin = :id AND usertype = 0";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Nếu nhân viên tồn tại, tiến hành xóa
        $sql = "DELETE FROM admin WHERE id_admin = :id AND usertype = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    } else {
        // Trả về false nếu nhân viên không tồn tại hoặc không phải nhân viên
        return false;
    }
}


