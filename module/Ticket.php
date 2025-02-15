<?php
require_once "db.php";  // Đảm bảo đã có file kết nối cơ sở dữ liệu

class Ticket
{
    private $db;

    public function __construct()
    {
        // Tạo đối tượng Database để kết nối cơ sở dữ liệu
        $database = new Database();
        $this->db = $database->connect();  // Lấy kết nối PDO từ lớp Database
    }

    public function getTicketsByUser($userId, $status = null)
    {
        // Truy vấn để lấy tất cả thông tin vé và các thông tin liên quan
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
                LEFT JOIN location location_from ON t.id_location_from = location_from.id_location
                LEFT JOIN location location_to ON t.id_location_to = location_to.id_location
                WHERE t.id_user = :userId";

        // Nếu có tham số $status, thêm điều kiện lọc vào câu truy vấn
        if ($status !== null) {
            $query .= " AND t.status = :status";
        }

        $query .= " ORDER BY t.date DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Nếu có điều kiện status, thêm tham số status vào câu lệnh
        if ($status !== null) {
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        }

        // Kiểm tra và in lỗi nếu truy vấn không thực thi thành công
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return [];
        }
    
        // Trả về tất cả các vé dưới dạng mảng
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
