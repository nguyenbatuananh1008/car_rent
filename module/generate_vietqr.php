<?php
function generateVietQR($bankCode, $accountNumber, $accountName, $amount, $description) {
    $url = "https://img.vietqr.io/image/MB-0000542277521-compact.png";

    // Thêm các tham số vào URL
    $url .= "?amount=$amount&addInfo=" . urlencode($description) . "&accountName=" . urlencode($accountName);

    return $url;
}

// Thông tin thanh toán
$bankCode = "MB"; // Mã ngân hàng (viết tắt)
$accountNumber = "0000542277521"; // Số tài khoản nhận
$accountName = "NGUYEN BA TUAN ANH"; // Tên chủ tài khoản
$amount = 500000; // Số tiền (VND)
$description = "Thanh toán đơn hàng 123"; // Nội dung thanh toán

// Gọi hàm tạo mã QR
$qrUrl = generateVietQR($bankCode, $accountNumber, $accountName, $amount, $description);

// Hiển thị QR code
echo "<h3>Quét mã QR để thanh toán</h3>";
echo "<img src='$qrUrl' alt='QR Code' />";
echo "<p>Nội dung thanh toán: $description</p>";
?>
