<?php
require_once 'db.php';

class TripSearcher {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function searchTrips($city_from, $city_to, $date) {
        $stmt = $this->conn->prepare("
            SELECT trip.*, 
                   city_from.name_city AS city_from_name, 
                   city_to.name_city AS city_to_name, 
                   car.img AS car_image, 
                   car.c_name AS car_name, 
                   car.capacity AS car_capacity,
                   car_house.name_c_house AS car_house_name,
                   trip.ticket_limit AS remaining_seats,
                   DATE_FORMAT(trip.t_pick, '%H:%i') AS t_pick,
                   DATE_FORMAT(trip.t_drop, '%H:%i') AS t_drop
            FROM trip
            JOIN city AS city_from ON trip.id_city = city_from.id_city
            JOIN city AS city_to ON trip.id_city_to = city_to.id_city
            JOIN car ON trip.id_car = car.id_car
            JOIN car_house ON car.id_c_house = car_house.id_c_house
            WHERE trip.id_city = :city_from 
              AND trip.id_city_to = :city_to 
        ");
        $stmt->execute([
            ':city_from' => $city_from,
            ':city_to' => $city_to,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function numberSeat($id_trip, $date) {
        $stmt = $this->conn->prepare("
            SELECT SUM(ticket.number_seat) AS total_seats
            FROM ticket 
            WHERE ticket.id_trip = :id_trip
              AND ticket.date = :date
        ");
        $stmt->execute([
            ':id_trip' => $id_trip,
            ':date' => $date,
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_seats'] ?? 0; 
    }
    
    
    
}
