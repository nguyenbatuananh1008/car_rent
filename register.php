<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "dat_ve"; 
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender']; 

    // Tránh SQL Injection (chắc chắn rằng dữ liệu đầu vào đã được xử lý)
    $fullname = $conn->real_escape_string($fullname);
    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    $gender = $conn->real_escape_string($gender);

    // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu 
    $check_email_sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($check_email_sql);

    if ($result->num_rows > 0) {
        // Nếu email đã tồn tại, thông báo lỗi
        echo "Error: Email already exists. Please use a different email.";
    } else {
        
        $sql = "INSERT INTO user (name, email, password, gender) VALUES ('$fullname', '$email', '$password', '$gender')";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.html');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
