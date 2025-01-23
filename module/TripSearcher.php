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
                    city_from.city_name AS city_from_name, 
                    city_to.city_name AS city_to_name, 
                    car.img AS car_image, 
                    car.c_name AS car_name, 
                    car.capacity AS car_capacity,
                    car_house.name_c_house AS car_house_name,
                    trip.t_limit AS remaining_seats,
                    DATE_FORMAT(trip.t_pick, '%H:%i') AS t_pick,
                    DATE_FORMAT(trip.t_drop, '%H:%i') AS t_drop
                FROM trip
                JOIN city AS city_from ON trip.id_city_from = city_from.id_city
                JOIN city AS city_to ON trip.id_city_to = city_to.id_city
                JOIN car ON trip.id_car = car.id_car
                JOIN car_house ON car.id_c_house = car_house.id_c_house
                WHERE trip.id_city_from = :city_from 
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
        public function getLocations($id_trip, $type) {
        $stmt = $this->conn->prepare("
            SELECT id_location, name_location,  DATE_FORMAT(time, '%H:%i') AS time
            FROM location 
            WHERE id_trip = :id_trip AND type = :type
        ");
        $stmt->execute([
            ':id_trip' => $id_trip,
            ':type' => $type,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createTicket($data) {
        $sql = "INSERT INTO ticket (id_trip, id_user, name, phone, number_seat, total_price, status, method, date)
        VALUES (:id_trip, :id_user, :name, :phone, :number_seat, :total_price, :status, :method, :date)";

                
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_trip' => $data['id_trip'],
            ':id_user' => $data['id_user'],
            ':name' => $data['name'],
            ':phone' => $data['phone'],
            ':number_seat' => $data['number_seat'],
            ':total_price' => $data['total_price'],
            ':status' => $data['status'],
            ':method' => $data['method'],
            ':date' => $data['date'],
        ]);
        
        
    }
    
    
    public function getTripById($id_trip) {
        $sql = "SELECT 
                    trip.id_trip, trip.price, trip.date, 
                    DATE_FORMAT(trip.t_pick, '%H:%i') AS t_pick, 
                    DATE_FORMAT(trip.t_drop, '%H:%i') AS t_drop, 
                    car.c_name AS car_name, car.capacity AS car_capacity, car.img AS car_image,
                    car_house.name_c_house AS car_house_name,
                    city_from.city_name AS city_from_name, 
                    city_to.city_name AS city_to_name

                FROM trip AS trip
                INNER JOIN car AS car ON trip.id_car = car.id_car
                INNER JOIN car_house AS car_house ON car.id_c_house = car_house.id_c_house
                INNER JOIN city AS city_from ON trip.id_city_from = city_from.id_city
                INNER JOIN city AS city_to ON trip.id_city_to = city_to.id_city
                WHERE trip.id_trip = :id_trip";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_trip', $id_trip, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
        
    }
