<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
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
<body>

<div class="main clearfix position-relative">
 <div class="main_1 clearfix position-absolute top-0 w-100">
   <section id="header">
     <nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
       <div class="container-xl">
         <a class="navbar-brand fs-3 p-0 fw-bold text-white" href="index.php"><i class="fa fa-car col_oran me-1 fs-2 align-middle"></i> Đặt Xe</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav mb-0">
             <li class="nav-item">
               <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="about.php">About</a>
             </li>  
             <li class="nav-item">
               <a class="nav-link" href="trip.php">Chuyến xe</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="blog.php">Blog</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="team.php">Team</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="contact.php">Contact</a>
             </li>
           </ul>
           <ul class="navbar-nav mb-0 ms-auto">
             <?php if (isset($_SESSION['user_id'])): ?>
               <li class="nav-item">
                 <a class="nav-link" href="profile.php">Profile</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link" href="logout.php">Logout</a>
               </li>
             <?php else: ?>
               <li class="nav-item">
                 <a class="nav-link" href="login.php">Sign In</a>
               </li>
               <li class="nav-item">
                 <a class="nav-link button_2 ms-2 me-2" href="register.php">Register <i class="fa fa-check-circle ms-1"></i></a>
               </li>
             <?php endif; ?>
           </ul>
         </div>
       </div>
     </nav>
   </section>
 </div>
</div>
