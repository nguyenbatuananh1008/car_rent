

<body>
    
<?php
 include('layout/header.php'); 
?>
<div class="container mt-4 ">
    <h3>Thông tin đặt vé</h3>
    <form action="process_booking.php" method="POST">
      

        <div class="form-group mt-3">
            <label for="tk_name">Tên người đi:</label>
            <input type="text" id="tk_name" name="tk_name" class="form-control" placeholder="Nhập tên" required>
        </div>

        <div class="form-group mt-3">
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="form-group mt-3">
            <label for="tk_email">Email:</label>
            <input type="email" id="tk_email" name="tk_email" class="form-control" placeholder="Nhập email" required>
        </div>

       

        <button type="submit" class="btn btn-primary mt-3">Đặt vé</button>
    </form>
</div>
</body>