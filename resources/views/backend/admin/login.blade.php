<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Pharmacy dashboard area" name="description">
		<meta content="Online doctor" name="doctor123">
		<meta name="keywords" content="Pharmacy dashboard"/>

		<!-- Title -->
		<title>Hostel login</title>

		<!--Favicon -->
		<link rel="icon" href="{{asset('')}}assets/images/brand/favicon.ico" type="image/x-icon"/>

		<!-- Bootstrap css -->
		<link href="{{asset('')}}assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

		<!-- Style css -->
		<link href="{{asset('')}}assets/css/style.css" rel="stylesheet" />

		<!-- Dark css -->
		<link href="{{asset('')}}assets/css/dark.css" rel="stylesheet" />

		<!-- Skins css -->
		<link href="{{asset('')}}assets/css/skins.css" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{asset('')}}assets/css/animated.css" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{asset('')}}assets/plugins/web-fonts/icons.css" rel="stylesheet" />
		<link href="{{asset('')}}assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
		<link href="{{asset('')}}assets/plugins/web-fonts/plugin.css" rel="stylesheet" />

	</head>

	<body class="h-100vh page-style1  light-mode">
		<div class="page">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-7 col-lg-5">
									<div class="card card-group mb-0">
										<div class="card p-4">
											<div class="card-body">
                                                <form method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                    <div class="text-center title-style mb-6">
                                                        <h1 class="mb-2">{{env('HOSTEL_NAME')}}</h1>
                                                        <hr>
                                                        <p class="text-muted">Sign In to your account</p>
                                                    </div>
                                                    @if (Session::has('successEmail'))
                                                        <div class="alert alert-success alert-dismissible fade show" id="alert-success-email" role="alert">
                                                            <span>{!! Session::get('successEmail') !!}</span>
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    @endif
                                                    @if (count($errors) > 0)
                                                        <div class="alert alert-danger" role="alert">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <a href="#" class="alert-link">{{ $error }}</a>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <div class="input-group mb-3">
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                                        </span>
                                                        <input id="email" name="email" type="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                                                    </div>
                                                    <div class="input-group mb-4">
                                                        <span class="input-group-addon">
                                                        <i class="fa fa-lock fa-lg"></i>
                                                        </span>
                                                        <input id="password" type="password" name="password" class="form-control" placeholder="Password" autocomplete="current-password">
                                                    </div>
                                     

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                                                <i class="fe fe-arrow-right"></i> Login
                                                            </button>
{{--                                                            <a href="dashboard.php" class="btn btn-lg btn-primary btn-block"><i class="fe fe-arrow-right"></i> Login</a>--}}
                                                        </div>
                                                      {{--   <div class="col-12">
                                                            <a href="forgot-password.php" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
                                                        </div> --}}
                                                    </div>
                                                </form>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Jquery js-->
		<script src="{{asset('')}}assets/js/vendors/jquery-3.5.1.min.js"></script>

		<!-- Bootstrap4 js-->
		<script src="{{asset('')}}assets/plugins/bootstrap/popper.min.js"></script>
		<script src="{{asset('')}}assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--Othercharts js-->
		<script src="{{asset('')}}assets/plugins/othercharts/jquery.sparkline.min.js"></script>

		<!-- Circle-progress js-->
		<script src="{{asset('')}}assets/js/vendors/circle-progress.min.js"></script>

		<!-- Jquery-rating js-->
		<script src="{{asset('')}}assets/plugins/rating/jquery.rating-stars.js"></script>

	</body>
</html>
