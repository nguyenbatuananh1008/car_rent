<?php
require_once "db.php";

class Ticket
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function getTicketsByUser($userId)
    {
        // Truy vấn để lấy thông tin vé và các thông tin liên quan
        $query = "SELECT 
                    t.id_ticket, 
                    t.date, 
                    t.number_seat, 
                    t.status, 
                    t.total_price, 
                    t.method, 
                    trip.t_pick, 
                    trip.t_drop, 
                    route.id_city_from, 
                    route.id_city_to, 
                    car.c_name,
                    car.c_plate,
                    car_house.name_c_house,
                    city_from.city_name AS from_city,
                    city_to.city_name AS to_city,
                    location_from.name_location AS from_location,
                    location_from.time AS from_time,
                    location_to.name_location AS to_location,
                    location_to.time AS to_time
                FROM ticket t
                INNER JOIN trip ON t.id_trip = trip.id_trip
                INNER JOIN route ON trip.id_route = route.id_route  
                INNER JOIN car ON trip.id_car = car.id_car
                INNER JOIN car_house ON car.id_c_house = car_house.id_c_house
                INNER JOIN city city_from ON route.id_city_from = city_from.id_city
                INNER JOIN city city_to ON route.id_city_to = city_to.id_city
                LEFT JOIN location location_from ON route.id_route = location_from.id_route AND location_from.type = 1  -- Điểm đón
                LEFT JOIN location location_to ON route.id_route = location_to.id_route AND location_to.type = 2  -- Điểm trả
                WHERE t.id_user = :userId
                ORDER BY t.date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        
        // Debug lỗi nếu truy vấn không chạy
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
