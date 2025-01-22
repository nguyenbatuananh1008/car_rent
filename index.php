<?php include('layout/header.php'); ?>

<body>
    <!-- Section Carousel -->
    <div class="main_2 clearfix">
        <section id="center" class="center_home">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <!-- Carousel Items --> 
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img src="img/bg8.jpg" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption d-md-block">
                            <h5>Plan your trip now</h5>
                            <h1 class="font_50 mt-4">Save <span class="col_oran">big</span> with our <br> car rental</h1>
                            <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
                            <a class="button" href="#searchSection">Book Ride <i class="fa fa-check-circle ms-1"></i></a>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <img src="img/bg7.jpg" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption d-md-block">
                            <h5>Plan your trip now</h5>
                            <h1 class="font_50 mt-4">Lorem <span class="col_oran">sit</span> dolor eget <br> sit amet</h1>
                            <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
                            <a class="button" href="#searchSection">Book Ride <i class="fa fa-check-circle ms-1"></i></a>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <img src="img/bg6.jpg" class="d-block w-100" alt="Slide 3">
                        <div class="carousel-caption d-md-block">
                            <h5>Plan your trip now</h5>
                            <h1 class="font_50 mt-4">Semp <span class="col_oran">port</span> diam quis <br> nulla porta</h1>
                            <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
                            <a class="button" href="#searchSection">Book Ride <i class="fa fa-check-circle ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    </div>

    <!-- Search Section -->
    <div class="main_3 position-absolute w-100 clearfix">
        <section id="booking">
            <div class="container-xl">
                <div id="searchSection">
                    <?php include "layout/searchBar.php"; ?>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <?php include('layout/footer.php'); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
