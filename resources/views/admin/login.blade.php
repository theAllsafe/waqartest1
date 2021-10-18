<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://ekan-admin-templates.multipurposethemes.com/images/favicon.ico">

    <title>Admin - Log in </title>
  
	<!-- Bootstrap 4.0-->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">
	
	<!-- Bootstrap extend-->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/bootstrap-extend.css') }}">
	
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/master_style.css') }}">

	<!-- Ekan Admin skins -->
	<link rel="stylesheet" href="{{ URL::asset('admin_assets/css/skins/_all-skins.css') }}">	


</head>
<body class="hold-transition dark bg-img" style="background-image: url({{ URL::asset('admin_assets/images/auth-bg/bg.jpg') }})" data-overlay="3">
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			
			<div class="col-12">
				<div class="row no-gutters">
					<div class="col-lg-4 col-md-5 col-12">
						<div class="content-top-agile p-10">					
						</div>
					</div>
					<div class="col-lg-4 col-md-5 col-12">
						<div class="content-top-agile p-10">
							<h2>Admin</h2>
							<p class="text-white">Sign in to start your session</p>							
						</div>
						<div class="p-30 content-bottom rounded bg-img box-shadowed" style="background-image: url(../../images/auth-bg/bg-1.jpg);" data-overlay="8">
							<form action="{{ url('makelogin') }}" method="post" class="form-element">
                			    @csrf
                			     @if(session()->has('error'))
                    			<div class="alert alert-danger">
                    					{{ session()->get('error') }}
                    				</div>
                    			@endif
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text bg-transparent bt-0 bl-0 br-0 no-radius text-white"><i class="ti-user"></i></span>
										</div>
										<input name="email" type="text" class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white" placeholder="Email">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text  bg-transparent bt-0 bl-0 br-0 text-white"><i class="ti-lock"></i></span>
										</div>
										<input name="password" type="password" class="form-control pl-15 bg-transparent bt-0 bl-0 br-0 text-white" placeholder="Password">
									</div>
								</div>
								  <div class="row">
									<!-- /.col -->
									<div class="col-12 text-center">
									  <button type="submit" class="btn btn-info btn-block margin-top-10">SIGN IN</button>
									</div>
									<!-- /.col -->
								  </div>
							</form>														

							<div class="text-center text-dark">
							  <p class="mt-50"></p>
							  <p class="gap-items-2 mb-20">
								  <a class="btn btn-outline" href="https://scsy.in/schoolbuddy/RTL/public/login"> عربي 
								  </a>
								</p>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<!-- jQuery 3 -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
	
	<!-- popper -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
	
	<!-- Bootstrap 4.0-->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

</body>
</html>
