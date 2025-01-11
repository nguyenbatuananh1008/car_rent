<?php
$target_dir = "../uploads/car";
$target_file = $target_dir . time() . '-' . basename($_FILES["img"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

//
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if($check !== false) {
        echo "Tệp là một hình ảnh - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Tệp không phải là một hình ảnh.";
        $uploadOk = 0;
    }
}

//
if (file_exists($target_file)) {
    echo "Xin lỗi, tệp đã tồn tại.";
    $uploadOk = 0;
}

// 
if ($_FILES["img"]["size"] > 500000) {
    echo "Xin lỗi, tệp của bạn quá lớn.";
    $uploadOk = 0;
}

// 
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Xin lỗi, chỉ chấp nhận các tệp JPG, JPEG, PNG & GIF.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Xin lỗi, tệp của bạn không được tải lên.";

} else {
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        echo "Tệp ". htmlspecialchars( basename( $_FILES["img"]["name"])). " đã được tải lên.";
    } else {
        echo "Xin lỗi, đã xảy ra lỗi khi tải tệp của bạn.";
    }
}
?>
