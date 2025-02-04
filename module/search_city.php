<?php
require_once 'db.php';

$db = new Database();
$conn = $db->connect();
$query = $_GET['q'] ?? '';

if ($query) {
    $stmt = $conn->prepare("SELECT id_city, city_name FROM city WHERE city_name LIKE :query LIMIT 10");
    $stmt->execute(['query' => '%' . $query . '%']);
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cities);
} else {
    echo json_encode([]);
}
?>
