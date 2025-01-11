<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đặt vé xe</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" >
	<link href="css/font-awesome.min.css" rel="stylesheet" >
	<link href="css/trip.css" rel="stylesheet">
	<link href="css/index.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>
</head>


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
	   <h6 class="d-inline-block me-2 mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
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
 <div class="booking_m clearfix bg-white">
   <div class="row booking_1">
  <div class="col-md-12">
   <h4 class="mb-0">Book a car</h4>
  </div>
 </div> 
 <div class="row booking_2 mt-4">
  <div class="col-md-4 col-sm-6">
   <div class="booking_2i">
    <h6 class="mb-3"><i class="fa fa-map-marker me-1 col_oran"></i> Điểm đi</h6>
	<?php require_once 'db.php';
	$sql = "SELECT l_pick FROM trip"; $result = $conn->query($sql);
	$options = [];
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { $options[] = $row['l_pick'];}
		} else {
			echo "0 có kết quả";
		}	?>
	<select class="form-select" id="example-select">
	<?php foreach ($options as $option) : ?>
		<option><?= htmlspecialchars($option) ?>
	</option> 
	<?php endforeach; ?> 
</select>
   </div>
  </div>
  <div class="col-md-4 col-sm-12">
   <div class="booking_2i">
    <h6 class="mb-3"><i class="fa fa-map-marker me-1 col_oran"></i> Điểm đến</h6>
	<?php require_once 'db.php';
	$sql = "SELECT l_drop FROM trip"; $result = $conn->query($sql);
	$options = [];
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) { $options[] = $row['l_drop'];}
		} else {
			echo "0 KQ";
		}	?>
	<select class="form-select" id="example-select">
	<?php foreach ($options as $option) : ?>
		<option><?= htmlspecialchars($option) ?>
	</option> 
	<?php endforeach; ?> 
</select>
   </div>
  </div>
 </div>
 
 <div class="row booking_2 mt-4">
  <div class="col-md-4 col-sm-6">
   <div class="booking_2i">
    <h6 class="mb-3"><i class="fa fa-calendar me-1 col_oran"></i> Giờ đón</h6>
	<div class="booking_2i1 row">
	 <div class="col-md-8">
	  <div class="booking_2i1l">
	    <input class="form-control" id="example-date" type="date" name="date">
	  </div>
	 </div>
	</div>
   </div>
  </div>
  <div class="col-md-4 col-sm-6">
   <div class="booking_2i">
    <h6 class="mb-3"><i class="fa fa-calendar me-1 col_oran"></i> Giờ đi</h6>
	<div class="booking_2i1 row">
	 <div class="col-md-8">
	  <div class="booking_2i1l">
	    <input class="form-control" id="example-date" type="date" name="date">
	  </div>
	 </div>
	</div>
   </div>
  </div>
  <div class="col-md-4 col-sm-12">
   <div class="booking_2i">
        <h6 class="mb-3"><i class="fa fa-search me-1 col_oran"></i> Find</h6>
		<h6 class="text-center mb-0">
			<a class="button pt-3 pb-3 d-block" href="trip.php">Tìm</a>
		</h6>		
   </div>
  </div>
 </div>
 </div>
</div>
</section>
 </div>
</div>


<section id="ride">
<div class="ride_m">
 <div class="container-xl">
 <div class="row ride_1">
  <div class="col-md-8">
   <div class="ride_1l">
    <h1 class="text-white">Save big with our cheap <br> car rental!</h1>
	<p class="text-light mb-0 fs-4 mt-3">Top Airports. Local Suppliers. 24/7 Support.</p>
   </div>
  </div>
  <div class="col-md-4">
   <div class="ride_1r mt-4 text-end">
     <h6 class="mb-0"><a class="button_2" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
   </div>
  </div>
 </div>
</div>
</div>
</section>

<div class="container-xl">
  <div class="row choose_1">
   <div class="col-md-7">
    <div class="choose_1l">
	 <h5 class="col_oran">Why Choose Us</h5>
	 <h1>Best valued deals you <br> will ever find</h1>
	 <p class="mt-3">Thrown shy denote ten ladies though ask saw. Or by to he going think order event music. Incommode so intention defective at convinced. Led income months itself and houses you.</p>
	 <h6 class="mb-0 mt-4"><a class="button" href="#">Find  Deals <i class="fa fa-check-circle ms-1"></i> </a></h6>
	</div>
   </div>
   <div class="col-md-5">
    <div class="choose_1r">
	 <div class="choose_1ri row">
	  <div class="col-md-3">
	   <div class="choose_1ril">
	    <span class="fs-1 d-inline-block text-center col_oran"><i class="fa fa-car"></i></span>
	   </div>
	  </div>
	  <div class="col-md-9">
	   <div class="choose_1rir">
	    <h4>Cross Country Drive</h4>
		<p class="mb-0 mt-3">Speedily say has suitable disposal add boy. On forth doubt miles of child. Exercise joy man children rejoiced.</p>
	   </div>
	  </div>
	 </div><hr>
	 <div class="choose_1ri row mt-3">
	  <div class="col-md-3">
	   <div class="choose_1ril">
	    <span class="fs-1 d-inline-block text-center col_oran"><i class="fa fa-dollar"></i></span>
	   </div>
	  </div>
	  <div class="col-md-9">
	   <div class="choose_1rir">
	    <h4>All Inclusive Pricing</h4>
		<p class="mb-0 mt-3">Speedily say has suitable disposal add boy. On forth doubt miles of child. Exercise joy man children rejoiced.</p>
	   </div>
	  </div>
	 </div><hr>
	 <div class="choose_1ri row mt-3">
	  <div class="col-md-3">
	   <div class="choose_1ril">
	    <span class="fs-1 d-inline-block text-center col_oran"><i class="fa fa-rupee"></i></span>
	   </div>
	  </div>
	  <div class="col-md-9">
	   <div class="choose_1rir">
	    <h4>No Hidden Charges</h4>
		<p class="mb-0 mt-3">Speedily say has suitable disposal add boy. On forth doubt miles of child. Exercise joy man children rejoiced.</p>
	   </div>
	  </div>
	 </div>
	</div>
   </div>
  </div>
  
</div>
</section>

<section id="testim" class="p_3 bg_light">
<div class="container-xl">
 <div class="row trip_1 text-center mb-4">
   <div class="col-md-12">
    <h5 class="col_oran">Reviewed by People</h5>
	<h1>Clients' Testimonials</h1>
	<p class="mb-0">To contribute to positive change and achieve our sustainability <br>  goals with many extraordinary</p>
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
		    <img src="img/6.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Semp Porta</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos aperiam porro necessitatibus, consequuntur, reiciendis
dolore doloribus id repellendus tempora vitae quia voluptas ipsum eligendi hic.</p>
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
		    <img src="img/7.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Eget Nulla</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos aperiam porro necessitatibus, consequuntur, reiciendis
dolore doloribus id repellendus tempora vitae quia voluptas ipsum eligendi hic.</p>
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
		    <img src="img/8.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Dapibus Diam</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos aperiam porro necessitatibus, consequuntur, reiciendis
dolore doloribus id repellendus tempora vitae quia voluptas ipsum eligendi hic.</p>
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
		    <img src="img/9.jpg" alt="abc" class="rounded-circle">
			<h4 class="mt-3">Per Conubia</h4>
			<h6 class="fw-normal col_light">CEO, Company Inc.</h6>
			<span class="font_50"><i class="fa fa-quote-left"></i></span>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos aperiam porro necessitatibus, consequuntur, reiciendis
dolore doloribus id repellendus tempora vitae quia voluptas ipsum eligendi hic.</p>
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

<?php include('footer.php'); ?>
