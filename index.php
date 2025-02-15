<?php include('layout/header.php'); 

?>

<body>
    <!-- Section Carousel -->
    <div class="main_2 clearfix">
        <section id="center" class="center_home">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false">
                <!-- Carousel Items --> 
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img src="img/bg8.jpg" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption d-md-block">
                            <h5>Plan your trip now</h5>
                            <h1 class="font_50 mt-4">Save <span class="col_oran">big</span> with our <br> car rental</h1>
                            <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item active">
                        <img src="img/bg6.jpg" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption d-md-block">
                            <h5>Plan your trip now</h5>
                            <h1 class="font_50 mt-4">Save <span class="col_oran">big</span> with our <br> car rental</h1>
                            <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Search Section - Đặt phần này dưới -->
    <div class="container-xl">
        <section id="booking">
            <div id="searchSection">
                <?php include "layout/searchBar.php"; ?>
            </div>
        </section>
    </div>

    <!-- Popular Routes Section - Hiển thị các tuyến đường phổ biến -->
    <div class="container-xl mt-5">
        <section id="popularRoutes">
            <div class="row">
                <h2 class="text-center">Tuyến đường phổ biến</h2>
                <div class="col-md-3">
                    <div class="card" onclick="window.location='trip_results.php?city_from=72&city_to=76&date=<?= date('Y-m-d') ?>'">
                        <img src="img/img_hero.png" class="card-img-top" alt="Hà Nội - Ninh Bình">
                        <div class="card-body">
                            <h5 class="card-title">Hà Nội - Thanh Hóa</h5>
                            <p class="card-text">Từ 170.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" onclick="window.location='trip_results.php?city_from=75&city_to=99&date=<?= date('Y-m-d') ?>'">
                        <img src="img/img_hero (2).png" class="card-img-top" alt="Hà Nội - Hải Phòng">
                        <div class="card-body">
                            <h5 class="card-title">Hà Nội - Hải Phòng</h5>
                            <p class="card-text">Từ 110.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" onclick="window.location='trip_results.php?city_from=72&city_to=99&date=<?= date('Y-m-d') ?>'">
                        <img src="img/img_hero (1).png" class="card-img-top" alt="Sài Gòn - Đà Lạt">
                        <div class="card-body">
                            <h5 class="card-title">Sài Gòn - Đà Lạt</h5>
                            <p class="card-text">Từ 270.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" onclick="window.location='trip_results.php?city_from=72&city_to=99&date=<?= date('Y-m-d') ?>'">
                        <img src="img/img_hero (3).png" class="card-img-top" alt="Sài Gòn - Phan Thiết">
                        <div class="card-body">
                            <h5 class="card-title">Sài Gòn - Phan Thiết</h5>
                            <p class="card-text">Từ 160.000đ</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php include('layout/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
