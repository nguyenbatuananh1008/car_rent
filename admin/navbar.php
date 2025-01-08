<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/car_rent/admin/dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/car_rent/admin/cars.php">Car</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/car_rent/admin/cars_house.php">Car house</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/car_rent/admin/manage_users.php">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/car_rent/admin/settings.php">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/car_rent/admin/logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>