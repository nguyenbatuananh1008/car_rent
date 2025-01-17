<?php include('layout/header.php'); ?>

<body>
	

 <div class="main_2 clearfix">
   <section id="center" class="center_home">
 <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" class="" aria-current="true"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/bg2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-md-block">
   <h5>Plan your trip now</h5>
   <h1 class="font_50 mt-4">Save <span class="col_oran">big</span> with our <br> car rental</h1>  
   <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
   <h6 class="d-inline-block me-2 mb-0"><a class="button" href="#searchSection">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
   <h6 class="d-inline-block mb-0"><a class="button_1" href="#">Learn More <i class="fa fa-check-circle ms-1"></i> </a></h6>   
</div>

    </div>
    <div class="carousel-item">
      <img src="img/bg3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-md-block">
       <h5>Plan your trip now</h5>
	   <h1 class="font_50 mt-4">Lorem <span class="col_oran">sit</span> dolor eget <br> sit amet</h1>	
	   <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
	   <h6 class="d-inline-block me-2 mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	   <h6 class="d-inline-block mb-0"><a class="button_1" href="#">Learn More <i class="fa fa-check-circle ms-1"></i> </a></h6>	
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/bg4.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-md-block">
       <h5>Plan your trip now</h5>
	   <h1 class="font_50 mt-4">Semp <span class="col_oran">port</span> diam quis <br> nulla porta</h1>	
	   <p class="mt-4 mb-4">To contribute to positive change and achieve our sustainability goals with many extraordinary</p>
	   <h6 class="d-inline-block me-2 mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	   <h6 class="d-inline-block mb-0"><a class="button_1" href="#">Learn More <i class="fa fa-check-circle ms-1"></i> </a></h6>	
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
<div class="main_3 position-absolute w-100 clearfix">
   <section id="booking">
      <div class="container-xl">
         <div id="searchSection"> <!-- Thêm ID ở đây -->
            <?php include "layout/searchBar.php"; ?>
         </div>
      </div>
   </section>
</div>







</body>

<?php include('layout/footer.php'); ?>
