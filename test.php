<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Ninh Bình Car</title>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
}

.card {
    border: 1px solid #dedede;
    border-radius: 8px;
    background: #fff;
    padding: 20px;
    margin: 20px;
    max-width: 400px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.image img {
    width: 100%;
    border-radius: 8px;
}

.details {
    margin-top: 15px;
}

.rating {
    color: #ff9f00;
}

.schedule {
    background: #e3f2fd;
    padding: 10px;
    border-radius: 5px;
    margin: 10px 0;
}

.flash-sale {
    background-color: #ff5722;
    color: #fff;
    padding: 5px;
    border-radius: 5px;
}

.price {
    font-size: 24px;
    font-weight: bold;
}

.discount {
    color: green;
}

.available-seats {
    margin: 10px 0;
    font-style: italic;
}

.choose-button {
    background: #ff9800;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.choose-button:hover {
    background: #e68900;
}
</style>
<body>
    <div class="card">
        <div class="image">
            <img src="your-image-url" alt="Ninh Bình Car">
        </div>
        <div class="details">
            <h2>Ninh Bình Car <span class="rating">4.6 ⭐ (179)</span></h2>
            <p>Limousine 12 chỗ</p>
            <div class="schedule">
                <div><strong>07:00</strong> - Văn phòng Hà Nội</div>
                <div>0h50m</div>
                <div><strong>07:50</strong> - Nam Định (Ý Yên)</div>
            </div>
            <div class="flash-sale">FLASH SALE <span class="sale-rating">4.3</span></div>
            <p class="price">170.000đ</p>
            <p class="discount">Giảm 50% tối đa 250K</p>
            <p class="available-seats">Còn 6 chỗ trống</p>
            <button class="choose-button">Chọn chuyến</button>
            <p class="note">* Vé chặng thuộc chuyến 07:00 01-03-2025 Hà Nội - Ninh Bình</p>
        </div>
    </div>
</body>
</html>