<?php
    require_once 'db.php';

    class TripSearcher {
        private $conn;

        public function __construct() {
            $db = new Database();
            $this->conn = $db->connect();
        }

        public function searchTrips($city_from, $city_to, $date) {
            // Đảm bảo định dạng ngày là Y-m-d
            try {
                $formattedDate = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            } catch (Exception $e) {
                return [];
            }
        
            // Truy vấn các chuyến xe theo tuyến (route)
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
                    DATE_FORMAT(trip.t_drop, '%H:%i') AS t_drop,
                    r.id_route
                FROM trip
                JOIN route r ON trip.id_route = r.id_route
                JOIN city city_from ON r.id_city_from = city_from.id_city
                JOIN city city_to ON r.id_city_to = city_to.id_city
                JOIN car ON trip.id_car = car.id_car
                JOIN car_house ON car.id_c_house = car_house.id_c_house
                WHERE 
                    (r.id_city_from = :city_from OR r.id_city_to = :city_to)
                    AND trip.t_pick >= :date
            ");
        
            $stmt->execute([
                ':city_from' => $city_from,
                ':city_to' => $city_to,
                ':date' => $formattedDate
            ]);
        
            // Lấy tất cả các chuyến xe
            $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            // Kiểm tra nếu không có chuyến nào
            if (!$trips) {
                return [];
            }
        
            // Xử lý từng chuyến xe để thêm thông tin tuyến đường đầy đủ
            foreach ($trips as &$trip) {
                $number_seat = $this->numberSeat($trip['id_trip'], $formattedDate);
                $trip['remaining_seats'] = (int) $trip['remaining_seats'] - (int) $number_seat;
        
                $trip['pickup_locations'] = $this->getLocations($trip['id_trip'], 0);
                $trip['dropoff_locations'] = $this->getLocations($trip['id_trip'], 1);
        
                // Thêm tuyến đường đầy đủ, nếu không có thì gán mặc định
                $trip['full_route'] = $this->getFullRoute($trip['id_route']) ?: 'Không xác định';
            }
        
            // Lọc các chuyến xe có số ghế còn lại > 0
            return array_filter($trips, function ($trip) {
                return $trip['remaining_seats'] > 0;
            });
        }
        
        

      
        
        // Phương thức lấy tên thành phố từ id thành phố
       public function getFullRoute($id_route) {
    // Lấy điểm xuất phát và điểm kết thúc
    $stmt = $this->conn->prepare("
        SELECT c1.city_name AS start_city, c2.city_name AS end_city
        FROM route r
        JOIN city c1 ON r.id_city_from = c1.id_city
        JOIN city c2 ON r.id_city_to = c2.id_city
        WHERE r.id_route = :id_route
    ");
    $stmt->execute([':id_route' => $id_route]);
    $route_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$route_info) return '';

    // Lấy danh sách điểm dừng theo thứ tự
    $stmt = $this->conn->prepare("
        SELECT city.city_name
        FROM route_stop rs
        JOIN city ON rs.id_city = city.id_city
        WHERE rs.id_route = :id_route
        ORDER BY rs.stop_order ASC
    ");
    $stmt->execute([':id_route' => $id_route]);
    $stops = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Ghép tuyến đường đầy đủ (bao gồm điểm đầu, điểm dừng và điểm cuố i)
    $full_route = array_merge([$route_info['start_city']], $stops, [$route_info['end_city']]);
    return implode(' > ', $full_route);
}

        
        
        
        
            
        
        
        
        public function numberSeat($id_trip, $date) {
            // Đảm bảo định dạng ngày là Y-m-d
            $dateTime = DateTime::createFromFormat('d-m-Y', $date);
            if ($dateTime === false) {
                // Nếu không thể chuyển đổi ngày, trả về 0 hoặc thông báo lỗi
            
                return 0;
            }
            // Chuyển ngày hợp lệ thành Y-m-d
            $formattedDate = $dateTime->format('Y-m-d');
        
            // Thực hiện truy vấn
            $stmt = $this->conn->prepare("
                SELECT SUM(ticket.number_seat) AS total_seats
                FROM ticket 
                WHERE ticket.id_trip = :id_trip
                AND ticket.date = :date
            ");
            $stmt->execute([
                ':id_trip' => $id_trip,
                ':date' => $formattedDate, // Sử dụng ngày đã định dạng
            ]);
        
            // Lấy kết quả và trả về
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
