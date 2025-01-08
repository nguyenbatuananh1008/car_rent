
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Chuyến xe</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" >
	<link href="css/font-awesome.min.css" rel="stylesheet" >
	<link href="css/trip.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<script src="https://kit.fontawesome.com/70889042d9.js" crossorigin="anonymous"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<?php include('header.php'); ?>
<body>
<div class="main_2 clearfix">
 <section id="center" class="center_o">
   <div class="center_om clearfix">
     <div class="container-xl">
  <div class="row center_o1">
   <div class="col-md-12">
      <h2 class="text-white">Chuyến xe phổ biến</h2>
	  <h6 class="mb-0 mt-3 fw-normal col_oran"><a class="text-light" href="#">Home</a> <span class="mx-2 col_light">/</span> Chuyến xe</h6>
   </div>
  </div>
 </div>
   </div>
 </section>
 </div>
<?php require_once 'db.php';?>
 <section id="model_pg" class="p_3">
<div class="container-xl">
  <div class="row model_pg1">
   <div class="col-md-4">
    <div class="model_pg1i clearfix">
	 <div class="model_pg1i1">
	   <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
				  <a href="#"><img src="<?php echo $img; ?>" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	 </div>
	 <div class="model_m p-3 clearfix border-top-0">
	   <div class="model_pg1i2 row">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2l">
	    <h4>Tên nhà xe</h4>
		<span class="font_12 col_yell">
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star-half-o"></i>
		  </span>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2r text-end">
	    <h3 class="mb-1"><i class="fa fa-dollar col_oran"></i> 73</h3>
		<h6 class="mb-0 font_14">per day</h6>
	   </div>
	  </div>
	 </div>
	 <div class="model_pg1i3 row mt-4 mb-4">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l">
			<h6><i class="fa-solid fa-clock col_oran me-1"></i> Pick_up</h6>
			<h6 class="mb-0 mt-3"><i class="fa-solid fa-clock col_oran me-1"></i> Drop_off</h6>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l text-end">
	     <h6><i class="fa fa-suitcase col_oran me-1"></i> 2 Luggage</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	 </div><hr>
	 
	 <div class="model_pg1i4 row text-center mt-4">
	  <div class="col-md-12">
	      <h6 class="mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	  </div>
	 </div>
	 </div>
	</div>
   </div>
   <div class="col-md-4">
    <div class="model_pg1i clearfix">
	 <div class="model_pg1i1">
	   <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/16.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	 </div>


	 <div class="model_m p-3 clearfix border-top-0">
	   <div class="model_pg1i2 row">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2l">
	    <h4>Tên nhà xe</h4>
		<span class="font_12 col_yell">
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star-half-o"></i>
		  </span>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2r text-end">
	    <h3 class="mb-1"><i class="fa fa-dollar col_oran"></i> 78</h3>
		<h6 class="mb-0 font_14">per day</h6>
	   </div>
	  </div>
	 </div>
	 <div class="model_pg1i3 row mt-4 mb-4">
		<div class="col-md-6 col-sm-6">
		  <div class="model_pg1i3l">
			<h6><i class="fa-solid fa-clock col_oran me-1"></i> Pick_up</h6>
			<h6 class="mb-0 mt-3"><i class="fa-solid fa-clock col_oran me-1"></i> Drop_off</h6>
		  </div>
		</div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l text-end">
	     <h6><i class="fa fa-suitcase col_oran me-1"></i> 2 Luggage</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	 </div><hr>
	 
	 <div class="model_pg1i4 row text-center mt-4">
	  <div class="col-md-12">
	      <h6 class="mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	  </div>
	 </div>
	 </div>
	</div>
   </div>
   <div class="col-md-4">
    <div class="model_pg1i clearfix">
	 <div class="model_pg1i1">
	   <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/17.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	 </div>
	 <div class="model_m p-3 clearfix border-top-0">
	   <div class="model_pg1i2 row">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2l">
	    <h4>Audi 3</h4>
		<span class="font_12 col_yell">
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star-half-o"></i>
		  </span>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2r text-end">
	    <h3 class="mb-1"><i class="fa fa-dollar col_oran"></i> 82</h3>
		<h6 class="mb-0 font_14">per day</h6>
	   </div>
	  </div>
	 </div>
	 <div class="model_pg1i3 row mt-4 mb-4">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l">
	     <h6><i class="fa fa-car col_oran me-1"></i> Sedan</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-male col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l text-end">
	     <h6><i class="fa fa-suitcase col_oran me-1"></i> 2 Luggage</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	 </div><hr>
	 
	 <div class="model_pg1i4 row text-center mt-4">
	  <div class="col-md-12">
	      <h6 class="mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	  </div>
	 </div>
	 </div>
	</div>
   </div>
  </div>
  <div class="row model_pg1 mt-4">
   <div class="col-md-4">
    <div class="model_pg1i clearfix">
	 <div class="model_pg1i1">
	   <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/18.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	 </div>
	 <div class="model_m p-3 clearfix border-top-0">
	   <div class="model_pg1i2 row">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2l">
	    <h4>Audi 1</h4>
		<span class="font_12 col_yell">
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star-half-o"></i>
		  </span>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2r text-end">
	    <h3 class="mb-1"><i class="fa fa-dollar col_oran"></i> 73</h3>
		<h6 class="mb-0 font_14">per day</h6>
	   </div>
	  </div>
	 </div>
	 <div class="model_pg1i3 row mt-4 mb-4">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l">
	     <h6><i class="fa fa-car col_oran me-1"></i> Sedan</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-male col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l text-end">
	     <h6><i class="fa fa-suitcase col_oran me-1"></i> 2 Luggage</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	 </div><hr>
	 
	 <div class="model_pg1i4 row text-center mt-4">
	  <div class="col-md-12">
	      <h6 class="mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	  </div>
	 </div>
	 </div>
	</div>
   </div>
   <div class="col-md-4">
    <div class="model_pg1i clearfix">
	 <div class="model_pg1i1">
	   <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/19.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	 </div>
	 <div class="model_m p-3 clearfix border-top-0">
	   <div class="model_pg1i2 row">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2l">
	    <h4>Audi 2</h4>
		<span class="font_12 col_yell">
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star-half-o"></i>
		  </span>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2r text-end">
	    <h3 class="mb-1"><i class="fa fa-dollar col_oran"></i> 78</h3>
		<h6 class="mb-0 font_14">per day</h6>
	   </div>
	  </div>
	 </div>
	 <div class="model_pg1i3 row mt-4 mb-4">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l">
	     <h6><i class="fa fa-car col_oran me-1"></i> Sedan</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-male col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l text-end">
	     <h6><i class="fa fa-suitcase col_oran me-1"></i> 2 Luggage</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	 </div><hr>
	 
	 <div class="model_pg1i4 row text-center mt-4">
	  <div class="col-md-12">
	      <h6 class="mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	  </div>
	 </div>
	 </div>
	</div>
   </div>
   <div class="col-md-4">
    <div class="model_pg1i clearfix">
	 <div class="model_pg1i1">
	   <div class="grid clearfix">
				  <figure class="effect-jazz mb-0">
					<a href="#"><img src="img/20.jpg" class="w-100" alt="abc"></a>
				  </figure>
			  </div>
	 </div>
	 <div class="model_m p-3 clearfix border-top-0">
	   <div class="model_pg1i2 row">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2l">
	    <h4>Audi 3</h4>
		<span class="font_12 col_yell">
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star"></i>
		   <i class="fa fa-star-half-o"></i>
		  </span>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i2r text-end">
	    <h3 class="mb-1"><i class="fa fa-dollar col_oran"></i> 82</h3>
		<h6 class="mb-0 font_14">per day</h6>
	   </div>
	  </div>
	 </div>
	 <div class="model_pg1i3 row mt-4 mb-4">
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l">
	     <h6><i class="fa fa-car col_oran me-1"></i> Sedan</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-male col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	  <div class="col-md-6 col-sm-6">
	   <div class="model_pg1i3l text-end">
	     <h6><i class="fa fa-suitcase col_oran me-1"></i> 2 Luggage</h6>
		 <h6 class="mb-0 mt-3"><i class="fa fa-female col_oran me-1"></i> 6 Seats</h6>
	   </div>
	  </div>
	 </div><hr>
	 
	 <div class="model_pg1i4 row text-center mt-4">
	  <div class="col-md-12">
	      <h6 class="mb-0"><a class="button" href="#">Book Ride <i class="fa fa-check-circle ms-1"></i> </a></h6>
	  </div>
	 </div>
	 </div>
	</div>
   </div>
  </div>
</div>
</section>
<script>
window.onscroll = function() {myFunction()};

var navbar_sticky = document.getElementById("navbar_sticky");
var sticky = navbar_sticky.offsetTop;
var navbar_height = document.querySelector('.navbar').offsetHeight;

function myFunction() {
  if (window.pageYOffset >= sticky + navbar_height) {
    navbar_sticky.classList.add("sticky")
	document.body.style.paddingTop = navbar_height + 'px';
  } else {
    navbar_sticky.classList.remove("sticky");
	document.body.style.paddingTop = '0'
  }
}
</script>

</body>

</html>
<?php include('footer.php'); ?>