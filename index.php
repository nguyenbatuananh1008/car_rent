<?php include('layout/header.php'); ?>

<body>
    <!-- Section Carousel -->
    <div class="main_2 clearfix">
        <section id="center" class="center_home">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="false">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img src="img/bg6.jpg" class="d-block w-100" alt="Slide 1">
                        <div class="carousel-caption d-md-block">
                            <h5>Lên lịch đặt xe ngay</h5>
                            <h1 class="font_50 mt-4">Save <span class="col_oran">big</span> with our <br> car rental</h1>
                            <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals.</p>
                            <a class="button" href="#">Đặt xe <i class="fa fa-check-circle ms-1"></i></a>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <img src="img/bg3.jpg" class="d-block w-100" alt="Slide 2">
                        <div class="carousel-caption d-md-block">
                            <h5>Lên lịch đặt xe ngay</h5>
                            <h1 class="font_50 mt-4">Comfortable <span class="col_oran">Trips</span> Await</h1>
                            <p class="mt-4 mb-4">Reliable car rentals for your convenience.</p>
                            <a class="button" href="#">Đặt xe <i class="fa fa-check-circle ms-1"></i></a>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <img src="img/bg8.jpg" class="d-block w-100" alt="Slide 3">
                        <div class="carousel-caption d-md-block">
                            <h5>Lên lịch đặt xe ngay</h5>
                            <h1 class="font_50 mt-4">Tiết kiệm <span class="col_oran">tiền</span> với <br> mã giảm giá</h1>
                            <p class="mt-4 mb-4">Chuyến xe tiện lợi, đi mọi tỉnh thành.</p>
                            <a class="button" href="#">Đặt xe <i class="fa fa-check-circle ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    </div>

    <!-- Search Section -->
    <div class="container-xl mt-4">
        <section id="booking">
            <div id="searchSection">
                <?php include "layout/searchBar.php"; ?>
            </div>
        </section>
    </div>

    <!-- Popular Routes Section -->
    <div class="container-xl mt-5">
        <section id="popularRoutes">
            <h2 class="text-center mb-4">Tuyến đường phổ biến</h2>
            <div class="row">
                <?php
                $routes = [
                    ['img/img_hero.png', 'Hà Nội - Thanh Hóa', 72, 76, '170.000đ'],
                    ['img/img_hero (2).png', 'Hà Nội - Hải Phòng', 75, 99, '110.000đ'],
                    ['img/img_hero (1).png', 'Sài Gòn - Đà Lạt', 72, 99, '270.000đ'],
                    ['img/img_hero (3).png', 'Sài Gòn - Phan Thiết', 72, 99, '160.000đ']
                ];

                foreach ($routes as $route) : ?>
                    <div class="col-md-3">
                        <div class="card" onclick="window.location='trip_results.php?city_from=<?= $route[2] ?>&city_to=<?= $route[3] ?>&date=<?= date('Y-m-d') ?>'">
                            <img src="<?= $route[0] ?>" class="card-img-top" alt="<?= $route[1] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $route[1] ?></h5>
                                <p class="card-text">Từ <?= $route[4] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <section id="testim" class="p_3 bg_light">
<div class="container-xl">
 <div class="row trip_1 text-center mb-4">
   <div class="col-md-12">
    <h5 class="col_oran">Đánh giá từ khách hàng</h5>
	<h1>Cảm nhận của khách hàng</h1>
	<p class="mb-0">Đóng góp vào sự thay đổi tích cực và đạt được mục tiêu bền vững <br> với nhiều trải nghiệm đáng nhớ</p>
   </div>
  </div> 
  <div class="row testim_1">
		  <div id="carouselExampleCaptions2" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="testim_1i row">
	     <div class="col-md-6">
		  <div class="testim_1i1 text-center p-4 pt-5 pb-5 bg-white rounded">
		    <img src="img/avt1.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Semp Porta</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p class="mb-0">Dịch vụ xe rất tuyệt vời, tài xế thân thiện và hành trình thoải mái. Tôi sẽ giới thiệu cho bạn bè của mình!</p>
             <span class="col_oran">
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star-half-o"></i>
			 </span>
		  </div>
		 </div>
		 <div class="col-md-6">
		  <div class="testim_1i1 text-center p-4 pt-5 pb-5 bg-white rounded">
		    <img src="img/avt2.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Eget Nulla</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p class="mb-0">Dịch vụ xe rất tuyệt vời, tài xế thân thiện và hành trình thoải mái. Tôi sẽ giới thiệu cho bạn bè của mình!</p>
             <span class="col_oran">
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star-half-o"></i>
			 </span>
		  </div>
		 </div>
	  </div>
    </div>
    <div class="carousel-item">
       <div class="testim_1i row">
	     <div class="col-md-6">
		  <div class="testim_1i1 text-center p-4 pt-5 pb-5 bg-white rounded">
		    <img src="img/avt3.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Dapibus Diam</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p class="mb-0">Dịch vụ xe rất tuyệt vời, tài xế thân thiện và hành trình thoải mái. Tôi sẽ giới thiệu cho bạn bè của mình!</p>
             <span class="col_oran">    
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star-half-o"></i>
			 </span>
		  </div>
		 </div>
		 <div class="col-md-6">
		  <div class="testim_1i1 text-center p-4 pt-5 pb-5 bg-white rounded">
		    <img src="img/avt4.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Per Conubia</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p class="mb-0">Dịch vụ xe rất tuyệt vời, tài xế thân thiện và hành trình thoải mái. Tôi sẽ giới thiệu cho bạn bè của mình!</p>
             <span class="col_oran">
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star"></i>
			  <i class="fa fa-star-half-o"></i>
			 </span>
		  </div>
		 </div>
	  </div>
    </div>
  </div>
</div>
</div>
</div>
</section>

    <!-- Footer -->
    <?php include('layout/footer.php'); ?>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>