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
                    DATE_FORMAT(location_from.time,'%H:%i') AS from_time,
                    location_to.name_location AS to_location,
                    DATE_FORMAT(location_to.time,'%H:%i') AS to_time
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
    
        // Lấy tất cả các vé dưới dạng mảng
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Định dạng lại ngày cho mỗi vé sau khi truy vấn
        foreach ($tickets as &$ticket) {
            $date = $ticket['date'];
    
            // Lấy tên ngày trong tuần (ví dụ: Thứ 2, Thứ 3, ...)
            $dayOfWeek = date('l', strtotime($date));
    
            // Chuyển đổi tên ngày trong tuần sang tiếng Việt
            $dayOfWeekInVietnamese = '';
            switch ($dayOfWeek) {
                case 'Sunday':
                    $dayOfWeekInVietnamese = 'CN';
                    break;
                case 'Monday':
                    $dayOfWeekInVietnamese = 'T2';
                    break;
                case 'Tuesday':
                    $dayOfWeekInVietnamese = 'T3';
                    break;
                case 'Wednesday':
                    $dayOfWeekInVietnamese = 'T4';
                    break;
                case 'Thursday':
                    $dayOfWeekInVietnamese = 'T5';
                    break;
                case 'Friday':
                    $dayOfWeekInVietnamese = 'T6';
                    break;
                case 'Saturday':
                    $dayOfWeekInVietnamese = 'T7';
                    break;
            }
    
            // Định dạng ngày thành kiểu 'd/m/Y' (22/01/2025)
            $formattedDate = date('d/m/Y', strtotime($date));
    
            // Kết hợp tên ngày và ngày tháng
            $ticket['formatted_date'] = $dayOfWeekInVietnamese . ", " . $formattedDate;
        }
    
        // Trả về tất cả các vé đã được định dạng ngày
        return $tickets;
    }
    

    public function cancelTicket($ticketId, $userId) {
        // Kiểm tra vé có tồn tại và thuộc về người dùng hiện tại
        $sql = "UPDATE ticket SET status = 2 WHERE id_ticket = :ticketId AND id_user = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        // Thực hiện câu lệnh
        if ($stmt->execute()) {
            return true; // Nếu thành công
        } else {
            return false; // Nếu không thành công
        }
    }
}
?>
