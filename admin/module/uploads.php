<?php
// Xử lý upload ảnh
$img = null;
if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {

    $img_name = time() . '_' . basename($_FILES['img']['name']);
    $img_path = '../uploads/' . $img_name;

    // Tạo thư mục 
    if (!is_dir('../uploads/')) {
        mkdir('../uploads/', 0777, true);
    }

    if (move_uploaded_file($_FILES['img']['tmp_name'], $img_path)) {
        $img = $img_name;
    }
}
?>