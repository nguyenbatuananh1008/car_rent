<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $bankName = $_POST['bankName'] ?? 'MBBank'; // Tên ngân hàng
    $accountNumber = $_POST['accountNumber'] ?? '0000542277521'; // Số tài khoản
    $amount = $_POST['amount'] ?? 0; // Số tiền
    $note = urlencode($_POST['note'] ?? ''); // Nội dung chuyển khoản (mã hóa URL)
    $fullName = urlencode($_POST['fullName'] ?? ''); // Tên người nhận (mã hóa URL)
    $template = $_POST['template'] ?? 'compact'; // Loại template: compact/basic

    // Kiểm tra số tiền
    if (!is_numeric($amount) || $amount <= 0) {
        echo json_encode(['error' => 'Số tiền không hợp lệ']);
        exit;
    }

    // Tạo URL API cho mã QR
    $qrUrl = "https://img.vietqr.io/image/{$bankName}-{$accountNumber}-{$template}.png?amount={$amount}&addInfo={$note}&accountName={$fullName}";

    // Trả về URL QR dưới dạng JSON
    echo json_encode(['qr_url' => $qrUrl]);
    exit;
}
?>
