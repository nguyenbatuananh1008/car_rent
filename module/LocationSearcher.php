<?php
require_once 'db.php';

class LocationSearcher {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getLocationsByTrip($id_trip) {
        $stmt = $this->conn->prepare("
            SELECT name_location, time, type, `order`
            FROM location
            WHERE id_trip = :id_trip
            ORDER BY type ASC, `order` ASC
        ");
        $stmt->execute([':id_trip' => $id_trip]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
