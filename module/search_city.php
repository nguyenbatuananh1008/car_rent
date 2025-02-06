<?php
// search_city.php
require_once 'db.php';
$db = new Database();
$conn = $db->connect();

$q = isset($_GET['q']) ? $_GET['q'] : '';

$query = "SELECT * FROM city WHERE city_name LIKE :q LIMIT 10";
$stmt = $conn->prepare($query);
$stmt->execute([':q' => '%' . $q . '%']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
