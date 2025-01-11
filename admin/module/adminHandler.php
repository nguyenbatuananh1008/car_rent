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

// Cập nhật thông tin admin (bao gồm ảnh)
function updateAdminInfo($id_admin, $name = null, $password = null, $image = null) {
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

    if ($image !== null) {
        $sql .= "image = :image, ";
        $params[':image'] = $image;
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
function getStaffList($search = null) {
    $db = new Database();
    $conn = $db->connect();

    if ($search) {
        $sql = "SELECT * FROM admin WHERE usertype = 0 AND (id_admin LIKE :search OR name LIKE :search OR email LIKE :search)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM admin WHERE usertype = 0";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Thêm nhân viên mới
function addStaff($name, $email, $password, $usertype, $image = null) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "INSERT INTO admin (name, email, password, usertype, image) VALUES (:name, :email, :password, :usertype, :image)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':usertype', $usertype, PDO::PARAM_INT);
    $stmt->bindParam(':image', $image);

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

// Cập nhật thông tin nhân viên (bao gồm ảnh)
function updateStaff($id, $name, $email, $password, $usertype, $image = null) {
    $db = new Database();
    $conn = $db->connect();

    $sql = "UPDATE admin SET name = :name, email = :email, password = :password, usertype = :usertype";

    if ($image !== null) {
        $sql .= ", image = :image";
    }

    $sql .= " WHERE id_admin = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':usertype', $usertype, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($image !== null) {
        $stmt->bindParam(':image', $image);
    }

    return $stmt->execute();
}

// Xóa nhân viên
function deleteUser($id) {
    $db = new Database();
    $conn = $db->connect();

    $checkSql = "SELECT * FROM admin WHERE id_admin = :id AND usertype = 0";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        $sql = "DELETE FROM admin WHERE id_admin = :id AND usertype = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    } else {
        return false;
    }
}
