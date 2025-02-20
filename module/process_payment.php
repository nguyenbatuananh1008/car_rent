<?php
// Bao gồm tệp kết nối cơ sở dữ liệu
include 'db.php';

// Tạo đối tượng kết nối
$database = new Database();
$db = $database->connect(); // Lấy kết nối PDO từ lớp Database

// Bắt đầu session để kiểm tra người dùng đã đăng nhập chưa
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
$id_user = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Nếu chưa đăng nhập, id_user sẽ là null

// Lấy dữ liệu từ form và kiểm tra nếu thiếu
$id_trip = $_POST['id_trip'] ?? null;
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = !empty($_POST['email']) ? $_POST['email'] : null;
$number_seat = $_POST['number_seat'] ?? 0;
$total_price = $_POST['total_price'] ?? 0;
$method = $_POST['method'] ?? 0; // Giá trị mặc định là 0 (Tiền mặt)
$date = $_POST['date'] ?? null;
$id_location_from  = $_POST['id_location_from'] ?? '';
$id_location_to  = $_POST['id_location_to'] ?? '';


if (!$id_trip || !$name || !$phone || !$number_seat || !$date) {
    die("Thiếu dữ liệu quan trọng! Vui lòng kiểm tra lại.");
}

// Định dạng lại ngày thành Y-m-d
$formattedDate = date('Y-m-d', strtotime($date));

// Xử lý logic cho `status` dựa trên `method`
$status = 0; // Mặc định status là 0 (vé đang chờ)
if ($method == 1) {
    // Nếu phương thức thanh toán là thẻ (method = 1), gán status là 1 (vé đã xác nhận)
    $status = 1;
}

// Câu lệnh SQL để chèn dữ liệu vào bảng ticket
$sql = "INSERT INTO ticket (id_trip, id_user,id_location_from,id_location_to, name, phone,email,number_seat, total_price, status, method, date)
        VALUES (:id_trip, :id_user,:id_location_from,:id_location_to ,:name, :phone,:email,:number_seat, :total_price, :status, :method, :date)";

// Sử dụng chuẩn bị câu lệnh SQL với kết nối PDO
$stmt = $db->prepare($sql);

// Liên kết tham số với các giá trị trong mảng $data
$stmt->bindParam(':id_trip', $id_trip);
$stmt->bindParam(':id_user', $id_user);
$stmt->bindParam(':id_location_from', $id_location_from);
$stmt->bindParam(':id_location_to', $id_location_to);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':number_seat', $number_seat);
$stmt->bindParam(':total_price', $total_price);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':method', $method);
$stmt->bindParam(':date', $formattedDate);

// Thực thi câu lệnh SQL
if ($stmt->execute()) {
  // Lưu thông tin vé vào session để hiển thị sau khi chuyển hướng
    $_SESSION['ticket_info'] = [
        'id_trip' => $id_trip,
        'name' => $name,
        'phone' => $phone,
        'email' => $email,
        'number_seat' => $number_seat,
        'total_price' => $total_price,
        'status' => $status,
        'method' => $method,
        'date' => $formattedDate,
        'car_name' => $_POST['car_name'] ?? '',
        'car_house_name' => $_POST['car_house_name'] ?? '',
        'pickup_location' => $_POST['pickup_location'] ?? '',
        'dropoff_location' => $_POST['dropoff_location'] ?? '',
        'pickup_time' => $_POST['pickup_time'] ?? '',
        'car_color' => $_POST['car_color'] ?? '',
        'car_capacity' => $_POST['car_capacity'] ?? '',
        'car_type' => $_POST['car_type'] ?? '',
        'car_image' => $_POST['car_image'] ?? ''
       
    ];

    header("Location:../ticket_details.php");
    exit();
} else {
    echo "Đã xảy ra lỗi trong quá trình thanh toán.";
}
?>

