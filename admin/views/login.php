<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Admin</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Đăng Nhập</h3>
                                </div>

<section id="login" class="p_3">
	<div class="container-xl">
		<div class="row">
			<div class="col-md-12">
				<div class="login_1 p-4 m-auto">
					<h3 class="col_oran">Login</h3>
					<form action="../module/login.php" method="POST">   
						<h6 class="mt-4">Email Address</h6>
						<input type="email" class="form-control" name="email" placeholder="Your Email" required>
						<h6 class="mt-4">Password</h6>
						<input type="password" class="form-control" name="password" placeholder="Your Password" required>
						<div class="d-flex justify-content-between mt-4">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="remember" id="remember">
								<label class="form-check-label" for="remember">Ghi nhớ</label>
							</div>
							<a class="col_oran" href="#">Quên mật khẩu</a>
						</div>
						<button type="submit" class="button mt-4">Login <i class="fa fa-sign-in ms-1"></i></button>
					</form>
				</div>
                    </div>
                    </div>
                </footer>
			</div>
                </footer>
		</div>
	</div>
</section>
</body>
</html>
