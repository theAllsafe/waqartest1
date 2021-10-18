@extends('admin.include.layout')
@section('mainarea')
<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->	  
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="page-title">Dashboard</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item active" aria-current="page">Control</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="right-title w-170">
					<!--<span class="subheader_daterange font-weight-600" id="dashboard_daterangepicker">-->
					<!--	<span class="subheader_daterange-label">-->
					<!--		<span class="subheader_daterange-title"></span>-->
					<!--		<span class="subheader_daterange-date text-info"></span>-->
					<!--	</span>-->
					<!--	<a href="#" class="btn btn-sm btn-info">-->
					<!--		<i class="fa fa-angle-down"></i>-->
					<!--	</a>-->
					<!--</span>-->
				</div>
			</div>
		</div>

		<!-- Main content -->
		<section class="content">
			
			<div class="row">
				<div class="col-xl-4 col-12">
					<div class="box box-body">
					  <h6 class="text-uppercase">Total Students</h6>
					  <div class="flexbox mt-2">
						<span class=" font-size-30">{{ $users->count() }}</span>
						<span class="ion ion-person text-danger font-size-40"></span>
					  </div>
					</div>
				</div>
				<!-- /.col -->

				<div class="col-xl-4 col-12">
					<div class="box box-body">
					  <h6 class="text-uppercase">Total Schools</h6>
					  <div class="flexbox mt-2">
						<span class=" font-size-30">{{ $tusers->count() }}</span>
						<span class="ion ion-person text-danger font-size-40"></span>
					  </div>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-xl-4 col-12">
					<div class="box box-body">
					  <h6 class="text-uppercase">ABC</h6>
					  <div class="flexbox mt-2">
						<span class=" font-size-30">15,845</span>
						<span class="ion ion-document text-primary font-size-40"></span>
					  </div>
					</div>
				</div>
				<!-- /.col -->
			
		</section>
		<!-- /.content -->
	  </div>
  </div>
  <!-- /.content-wrapper -->
@endsection