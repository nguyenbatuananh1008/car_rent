    <?php
    $method = [
        0 => 'Tiền mặt',
        1 => 'Thẻ tín dụng',
        2 => 'Chuyển khoản'
    ];

    $status = [
        0 => 'Chưa thanh toán',
        1 => 'Đã thanh toán',
        2 => 'Đã hủy',
        3 => 'Đã đi'
    ];

    function formatMoney($amount)
    {
        return number_format($amount, 0, ',', '.') . ' đ';
    }

    function formatDay($date)
    {
        $timestamp = strtotime($date); 
        return date('d-m-Y', $timestamp); 
    }
    ?>

