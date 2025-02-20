<?php
    require_once 'db.php';

    class TripSearcher {
        private $conn;

        public function __construct() {
            $db = new Database();
            $this->conn = $db->connect();
        }
                    public function searchTrips($city_from, $city_to, $date, $sort = 'default') {
                        try {
                            // Đảm bảo định dạng ngày chính xác
                            $formattedDate = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                        } catch (Exception $e) {
                            return [];
                        }
                    
                        // Xác định điều kiện sắp xếp
                        $orderBy = "";
                        switch ($sort) {
                            case 'earliest':
                                $orderBy = "ORDER BY trip.t_pick ASC"; // Giờ đi sớm nhất
                                break;
                            case 'latest':
                                $orderBy = "ORDER BY trip.t_pick DESC"; // Giờ đi muộn nhất
                                break;
                            case 'price_asc':
                                $orderBy = "ORDER BY trip.price ASC"; // Giá tăng dần (cả chuyến)
                                break;
                            case 'price_desc':
                                $orderBy = "ORDER BY trip.price DESC"; // Giá giảm dần (cả chuyến)
                                break;
                            default:
                                $orderBy = "ORDER BY trip.t_pick ASC"; // Mặc định: Giờ đi sớm nhất
                                break;
                        }
                    
                        // Truy vấn chuyến xe với các điều kiện tìm kiếm
                        $stmt = $this->conn->prepare("
                                    SELECT DISTINCT trip.*, 
                                        city_from.city_name AS city_from_name, 
                                        city_to.city_name AS city_to_name, 
                                        car.img AS car_image, 
                                        car.c_name AS car_name, 
                                        car.c_type AS car_type,
                                        car.c_color AS car_color,
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
                                    LEFT JOIN route_stop rs ON r.id_route = rs.id_route
                                    LEFT JOIN city city_stop ON rs.id_city = city_stop.id_city
                                    WHERE 
                                        (
                                            -- Tìm kiếm chuyến xe từ city_from đến city_to
                                            (r.id_city_from = :city_from AND r.id_city_to = :city_to)  
                                            OR
                                            -- Tìm kiếm chuyến xe từ city_from đến city_to có điểm dừng ở city_to
                                            (r.id_city_from = :city_from AND rs.id_city = :city_to)
                                            OR
                                            -- Tìm chuyến xe có điểm dừng ở city_from và city_to
                                            (rs.id_city = :city_from AND rs.id_city = :city_to) 
                                            OR
                                            -- Tìm chuyến xe có điểm dừng ở city_from và điểm cuối ở city_to
                                            (rs.id_city = :city_from AND r.id_city_to = :city_to)
                                            OR
                                            -- Tìm chuyến xe có type = 0 từ city_from đến type = 1 ở city_to
                                            (rs.type = 0 AND rs.id_city = :city_from AND EXISTS 
                                                (SELECT 0 FROM route_stop rs2 
                                                WHERE rs2.id_route = rs.id_route 
                                                AND rs2.type = 1 
                                                AND rs2.id_city = :city_to))
                                        )
                                        AND trip.t_pick >= :date
                                    $orderBy
                                ");

                    
                        $stmt->execute([
                            ':city_from' => $city_from,
                            ':city_to' => $city_to,
                            ':date' => $formattedDate
                        ]);
                    
                        // Lấy danh sách chuyến xe
                        $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if (!$trips) {
                            return [];
                        }
                    
                        // Xử lý từng chuyến xe để thêm thông tin tuyến đường đầy đủ và giá vé từng chặng
                        $trips = array_map(function ($trip) use ($formattedDate) {
                            $number_seat = $this->numberSeat($trip['id_trip'], $formattedDate);
                            $trip['remaining_seats'] = (int) $trip['remaining_seats'] - (int) $number_seat;
                    
                            $trip_id = $trip['id_trip'];
                    
                            // Lấy thông tin điểm đón và trả
                            $pickup_locations = $this->getPickupLocations($trip_id);
                            $dropoff_locations = $this->getDropoffLocations($trip_id);
                    
                            // Thêm thông tin vào chuyến đi (nếu có)
                            $trip['pickup_locations'] = $pickup_locations ?? [];
                            $trip['dropoff_locations'] = $dropoff_locations ?? [];
                    
                            // Lấy tuyến đường đầy đủ (bao gồm cả điểm dừng)
                            $trip['full_route'] = $this->getFullRoute($trip['id_route']) ?: 'Không xác định';
                    
                            // Lấy giá vé theo từng chặng từ bảng `trip_prices`
                            $trip['segment_prices'] = $this->getSegmentPrices($trip['id_trip']);
                    
                            return $trip;
                        }, $trips);
                    
                        // Lọc các chuyến xe có ghế trống và không bị trùng lặp
                        return array_values(array_unique($trips, SORT_REGULAR));
                    }
                    
        
        
        
        
        
        
        

      
        
        // Phương thức lấy tên thành phố từ id thành phố
            public function getSegmentPrices($id_trip) {
                $stmt = $this->conn->prepare("
                    SELECT tp.id_trip, c1.city_name AS city_from_name, c2.city_name AS city_to_name, tp.base_price
                    FROM trip_prices tp
                    JOIN city c1 ON tp.id_city_from = c1.id_city
                    JOIN city c2 ON tp.id_city_to = c2.id_city
                    WHERE tp.id_trip = :id_trip
                ");
                $stmt->execute([':id_trip' => $id_trip]);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

        
    
        // Lấy tên thành phố theo id_city
        public function getCityName($id_city) {
            $stmt = $this->conn->prepare("SELECT city_name FROM city WHERE id_city = :id_city");
            $stmt->execute([':id_city' => $id_city]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['city_name'] ?? 'Không xác định';
        }
    
        // Lấy tuyến đường đầy đủ (bao gồm cả điểm dừng)
        public function getFullRoute($id_route) {
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
                ORDER BY rs.type ASC
            ");
            $stmt->execute([':id_route' => $id_route]);
            $stops = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // Ghép tuyến đường đầy đủ (bao gồm điểm đầu, điểm dừng và điểm cuối)
            $full_route = array_merge([$route_info['start_city']], $stops, [$route_info['end_city']]);
            return implode(' > ', $full_route);
        }
        public function getCarSeats($id_car) {
            $stmt = $this->conn->prepare("SELECT capacity FROM car WHERE id_car = :id_car");
            $stmt->execute([':id_car' => $id_car]);
            $car = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $car['capacity'] ?? 0; // Trả về số ghế của xe
        }
        
        
        
        
        
            
        
        
        
        public function numberSeat($id_trip, $date) {
            // Đảm bảo định dạng ngày là Y-m-d
            $dateTime = DateTime::createFromFormat('d-m-Y', $date);
            if ($dateTime === false) {
                // Nếu không thể chuyển đổi ngày, trả về 0 hoặc thông báo lỗi
            
                return 0;
            }
           
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
        
        
    public function getPickupLocations($id_route) {
        $stmt = $this->conn->prepare("
            SELECT loc.id_location,loc.name_location, city.city_name, city.id_city, DATE_FORMAT(loc.time, '%H:%i') AS pickup_time
            FROM location loc
            JOIN city city ON loc.id_city = city.id_city
            WHERE loc.id_route = :id_route AND loc.type = 0
            ORDER BY loc.time ASC
        ");
        $stmt->execute([':id_route' => $id_route]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getDropoffLocations($id_route) {
        $stmt = $this->conn->prepare("
            SELECT loc.id_location,loc.name_location, city.city_name, city.id_city, DATE_FORMAT(loc.time, '%H:%i') AS dropoff_time
            FROM location loc
            JOIN city city ON loc.id_city = city.id_city
            WHERE loc.id_route = :id_route AND loc.type = 1
            ORDER BY loc.time ASC
        ");
        $stmt->execute([':id_route' => $id_route]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTripPrice($trip_id, $pickup_city_id, $dropoff_city_id) {
        // Kiểm tra nếu thành phố từ và đến trùng nhau
        if ($pickup_city_id == $dropoff_city_id) {
            return ['price' => 'Lỗi: Trùng thành phố'];
        }
    
        // Kiểm tra giá từ bảng trip_prices cho chặng nhỏ
        $stmt = $this->conn->prepare("
            SELECT tp.base_price
            FROM trip_prices tp
            WHERE tp.id_trip = :trip_id
            AND tp.id_city_from = :pickup_city_id
            AND tp.id_city_to = :dropoff_city_id
        ");
        $stmt->execute([
            ':trip_id' => $trip_id,
            ':pickup_city_id' => $pickup_city_id,
            ':dropoff_city_id' => $dropoff_city_id
        ]);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Nếu có giá cho chặng nhỏ, trả về giá từ trip_prices
        if ($result) {
            return ['price' => $result['base_price']];
        }
    
        // Kiểm tra nếu là tuyến đường (cả tuyến đường) lấy giá từ bảng route và trip
        $stmt = $this->conn->prepare("
            SELECT t.price
            FROM route r
            JOIN trip t ON t.id_route = r.id_route
            WHERE r.id_city_from = :pickup_city_id
            AND r.id_city_to = :dropoff_city_id
            AND t.id_trip = :trip_id
        ");
        $stmt->execute([
            ':pickup_city_id' => $pickup_city_id,
            ':dropoff_city_id' => $dropoff_city_id,
            ':trip_id' => $trip_id
        ]);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Nếu có kết quả, trả về giá từ bảng trip
        if ($result) {
            return ['price' => $result['price']];
        }
    
        // Nếu không có giá, trả về lỗi
        return ['price' => 'Lỗi: Không'];
    }
    
    
    
    
   
    
        
    }
