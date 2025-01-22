<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $bankName = $_POST['bankName'] ?? 'MBBank'; // Tên ngân hàng
    $accountNumber = $_POST['accountNumber'] ?? '0000542277521'; // Số tài khoản
    $amount = $_POST['amount'] ?? 0; // Số tiền
    $note = urlencode($_POST['note'] ?? ''); // Nội dung chuyển khoản (mã hóa URL)
    $fullName = urlencode($_POST['fullName'] ?? ''); // Tên người nhận (mã hóa URL)
    $template = $_POST['template'] ?? 'compact'; // Loại template: compact/basic

    // Tạo URL API cho mã QR
    $qrUrl = "https://api.vieqr.com/vietqr/{$bankName}/{$accountNumber}/{$amount}/{$template}.jpg?NDck={$note}&FullName={$fullName}";

    // Trả về URL QR dưới dạng JSON
    echo json_encode(['qr_url' => $qrUrl]);
    exit;
}
?>
