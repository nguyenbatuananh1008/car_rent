<?php
function convertDateToDMY($date, $inputFormat = 'Y-m-d') {
    // Tạo đối tượng DateTime từ ngày đầu vào và định dạng đầu vào
    $dateTime = DateTime::createFromFormat($inputFormat, $date);
    
    // Kiểm tra nếu ngày hợp lệ
    if (!$dateTime) {
        return "Invalid date or format"; // Trả về lỗi nếu không hợp lệ
    }

    // Chuyển đổi ngày sang định dạng d-m-Y
    return $dateTime->format('d-m-Y');
}
?>
