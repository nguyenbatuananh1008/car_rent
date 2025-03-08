<?php include('layout/header.php'); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thuê Xe</title>
	<link href="css/contact.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<script src="js/bootstrap.bundle.min.js"></script>
	<!-- Bootstrap JS và Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</head>
   
 <div class="main_2 clearfix">
 <section id="center" class="center_contact">
   <div class="center_om clearfix">
     <div class="container-xl">
  <div class="row center_o1">
   <div class="col-md-12">
      <h2 class="text-white">Liên Hệ</h2>
	  <h6 class="mb-0 mt-3 fw-normal col_oran"><a class="text-light" href="#">Trang chủ</a> <span class="mx-2 col_light">/</span> Liên hệ</h6>
   </div>
  </div>
 </div>
   </div>
 </section>
 </div>

<section id="contact" class="p_3">
 <div class="container-xl">
   <div class="contact_1 row">
    <div class="col-md-4 col-sm-4">
	 <div class="contact_1i row bg_light ms-1 me-1 ps-2 pe-2 pt-4 pb-4">
	  <div class="col-md-3">
	   <div class="contact_1il">
	    <span class="d-inline-block bg_oran text-white text-center rounded-circle fs-2"><i class="fa fa-map"></i></span>
	   </div>
	  </div>
	  <div class="col-md-9">
	   <div class="contact_1ir">
	    <h5>Địa Chỉ Của Chúng Tôi</h5>
		<p class="mb-0 fs-6">Đồng Phát Park View, Vĩnh Hoàng, Hoàng Mai, Hà Nội.</p>
	   </div>
	  </div>
	 </div>
	</div>
	<div class="col-md-4 col-sm-4">
	 <div class="contact_1i row bg_light ms-1 me-1 ps-2 pe-2 pt-4 pb-4">
	  <div class="col-md-3">
	   <div class="contact_1il">
	    <span class="d-inline-block bg_oran text-white text-center rounded-circle fs-2"><i class="fa fa-phone"></i></span>
	   </div>
	  </div>
	  <div class="col-md-9">
	   <div class="contact_1ir">	
	    <h5>Số Điện Thoại</h5>
		<p class="mb-0 fs-6"> +(000) 345 67 89</p>
	   </div>
	  </div>
	 </div>
	</div>
	<!--  -->
	<div class="col-md-4 col-sm-4">
	 <div class="contact_1i row bg_light ms-1 me-1 ps-2 pe-2 pt-4 pb-4">
	  <div class="col-md-3">
	   <div class="contact_1il">
	    <span class="d-inline-block bg_oran text-white text-center rounded-circle fs-2"><i class="fa fa-envelope"></i></span>
	   </div>
	  </div>
	  <div class="col-md-9">
	   <div class="contact_1ir">
	    <h5>Gửi Email Cho Chúng Tôi</h5>
		<p class="mb-0 fs-6">Vietcar@gmail.com</p>
	   </div>
	  </div>
	 </div>
	</div>
   </div>
   <div class="contact_2 row mt-5">
    <div class="col-md-5">
	 <div class="contact_2l">
	   <h5 class="col_oran">Liên Hệ Với Chúng Tôi</h5>
	   <h1 class="font_50 mt-3">Có Câu Hỏi Nào Không?</h1>
	   <p class="mt-3">Khám phá các yếu tố cách mạng để thay đổi và phát triển web &amp; ứng dụng tối ưu, phù hợp với các xu hướng mới nhất.</p>
	   <ul class="social-network social-circle mb-0 mt-3">
					<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-pinterest"></i></a></li>
					<li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#" class="icoLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
				</ul>
	 </div>
	</div>
	<div class="col-md-7">
	 <div class="contact_2r">
	 <form action="module/contact_p.php" method="POST">
	   <div class="blog_1rdt3i2 row">
		 <div class="col-md-6">
		  <div class="blog_1rdt3i2l">
		  <input class="form-control" placeholder="Họ và Tên" type="text" name="name" required>
		  </div>
		 </div> 
		 <div class="col-md-6">
		  <div class="blog_1rdt3i2l">
		  <input class="form-control" placeholder="Email" type="text" name="email" required>
		  </div>
		 </div>
		</div>
		<div class="blog_1rdt3i2 row mt-3">
		 <div class="col-md-6">
		  <div class="blog_1rdt3i2l">
		  <input class="form-control" placeholder="Chủ Đề" type="text" name="subject" required>
		  </div>
		 </div> 
		 <div class="col-md-6">
		  <div class="blog_1rdt3i2l">
		  <input class="form-control" placeholder="Số điện thoại" type="text" name="phone" required>
		  </div>
		 </div>
		</div>
		<div class="blog_1rdt3i2 row mt-3">
		 <div class="col-md-12">
		  <div class="blog_1rdt3i2l">
		  <textarea placeholder="Thông điệp" class="form-control form_text" name="message" required></textarea>
		  <br>
		  <div class="text-end">
        <button type="submit" class="button btn btn-primary">
            Gửi Ngay <i class="fa fa-check-circle ms-1"></i>
        </button>
    </div>  
		</form>
		</div>
		 </div> 
		</div>
	 </div>
	</div>
   </div>
   
   <!--  -->
   <div class="contact_3 row mt-4">
    <div class="col-md-12">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3676.7625691222843!2d105.86839071075435!3d20.981864680575075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac21fa49b27f%3A0xed524f32b70ff487!2sPark%20View%20Tower%20t%C3%B2a%20A!5e1!3m2!1svi!2s!4v1741139057376!5m2!1svi!2s" height="450" style="border:0; width:100%;" allowfullscreen=""></iframe>
	</div>	
   </div>
 </div>
</section>

<section id="ride">
<div class="ride_m">
 <div class="container-xl">
 <div class="row ride_1">
  <div class="col-md-8">
   <div class="ride_1l">
    <h1 class="text-white">Tiết kiệm lớn với dịch vụ đặt vé xe giá rẻ của chúng tôi!</h1>
	<p class="text-light mb-0 fs-4 mt-3">Sân bay lớn. Nhà cung cấp địa phương. Hỗ trợ 24/7.</p>
   </div>
  </div>
  <div class="col-md-4">
   <div class="ride_1r  text-end">
     <h6 class="text-white"><i class="fa fa-phone me-1"></i> Gọi để đặt xe</h6>
     <h6 class="mb-0 mt-3"><a class="button_2" href="#">Đặt Xe Ngay <i class="fa fa-check-circle ms-1"></i> </a></h6>
	 <h3 class="col_oran mt-3 mb-0">+(000) 345 67 89</h3>
   </div>
  </div>
 </div>
</div>
</div>
</section>

<!-- Footer -->
<?php include('layout/footer.php'); ?>

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
