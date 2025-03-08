<?php
require_once 'db.php';
$db = new Database();
$conn = $db->connect(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact (name, subject, email, phone, message) 
            VALUES (:name, :subject, :email, :phone, :message)";

    try {
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':message', $message);

        $stmt->execute();

        header("Location: Success.php");
        exit(); 

    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>
