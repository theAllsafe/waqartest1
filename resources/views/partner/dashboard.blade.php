@extends('partner.include.layout')
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
					<span class="subheader_daterange font-weight-600" id="dashboard_daterangepicker">
						<span class="subheader_daterange-label">
							<span class="subheader_daterange-title"></span>
							<span class="subheader_daterange-date text-info"></span>
						</span>
						<a href="#" class="btn btn-sm btn-info">
							<i class="fa fa-angle-down"></i>
						</a>
					</span>
				</div>
			</div>
		</div>

		<!-- Main content -->
		<section class="content">
			
			<div class="row">
				<div class="col-xl-4 col-12">
					<div class="box box-body">
					  <h6 class="text-uppercase">EMPLOYEES</h6>
					  <div class="flexbox mt-2">
						<span class=" font-size-30">85,987</span>
						<span class="ion ion-person text-danger font-size-40"></span>
					  </div>
					</div>
				</div>
				<!-- /.col -->

				<div class="col-xl-4 col-12">
					<div class="box box-body">
					  <h6 class="text-uppercase">MESSAGES</h6>
					  <div class="flexbox mt-2">
						<span class=" font-size-30">2,951</span>
						<span class="ion ion-email text-info font-size-40"></span>
					  </div>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-xl-4 col-12">
					<div class="box box-body">
					  <h6 class="text-uppercase">VISITORS</h6>
					  <div class="flexbox mt-2">
						<span class=" font-size-30">15,845</span>
						<span class="ion ion-document text-primary font-size-40"></span>
					  </div>
					</div>
				</div>
				<!-- /.col -->
		    </div>					
			
			<div class="row">
				<div class="col-xl-7 col-12">
					<div class="box">
					  <div class="box-header with-border">
						<h4 class="box-title">Data Overview</h4>
					  </div>

					  <div class="box-body">
						  <div id="e_chart_1" class="chart" style="height:400px;"></div>
					  </div>
					</div>
				</div>

				<div class="col-xl-5 col-12">			
				  <!-- Chart -->
				  <div class="box">
					<div class="box-header with-border">
					  <h4 class="box-title">Social Ads Campaigns</h4>
					</div>
					<div class="box-body">
						<div id="e_chart_2" class="chart" style="height:400px;"></div>
					</div>
					<!-- /.box-body -->
				  </div>
				  <!-- /.box -->
				</div>
				
				<div class="col-xl-8 col-12">
					<div class="box">
					  <div class="box-header">
						<h4 class="box-title">Recent Orders</h4>
					  </div>
					  <div class="box-body">
						<div class="table-responsive">
						  <table class="table table-hover mb-5">
							<thead>
							  <tr>
								<th>SKU</th>
								<th>Invoice#</th>
								<th>Customer Name</th>
								<th>Status</th>
								<th>Amount</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td>PO-10521</td>
								<td><a href="#">INV-001001</a></td>
								<td>Elizabeth W.</td>
								<td>
								  <span class="badge badge-success">Paid</span>
								</td>
								<td>$ 1200.00</td>
							  </tr>
							  <tr>
								<td>PO-532521</td>
								<td><a href="#">INV-01112</a></td>
								<td>Doris R.</td>
								<td>
								  <span class="badge badge-warning">Overdue</span>
								</td>
								<td>$ 5685.00</td>
							  </tr>
							  <tr>
								<td>PO-05521</td>
								<td><a href="#">INV-001012</a></td>
								<td>Andrew D.</td>
								<td>
								  <span class="badge badge-success">Paid</span>
								</td>
								<td>$ 152.00</td>
							  </tr>
							  <tr>
								<td>PO-15521</td>
								<td><a href="#">INV-001401</a></td>
								<td>Megan S.</td>
								<td>
								  <span class="badge badge-success">Paid</span>
								</td>
								<td>$ 1450.00</td>
							  </tr>
							  <tr>
								<td>PO-32521</td>
								<td><a href="#">INV-008101</a></td>
								<td>Walter R.</td>
								<td>
								  <span class="badge badge-warning">Overdue</span>
								</td>
								<td>$ 685.00</td>
							  </tr>
							  <tr>
								<td>PO-532521</td>
								<td><a href="#">INV-01112</a></td>
								<td>Doris R.</td>
								<td>
								  <span class="badge badge-warning">Overdue</span>
								</td>
								<td>$ 5685.00</td>
							  </tr>
							</tbody>
						  </table>
						</div>
					  </div>
					</div>
				  </div>
				<div class="col-xl-4 col-12">
					<div class="box">
					  <div class="box-header">
						<h4 class="box-title">Recent Buyers</h4>
					  </div>
					  <div class="box-body px-1">
						<div id="recent-buyers" class="media-list">
						  <a href="#" class="media xs-media p-5">
							<div class="media-left pr-1">
							  <span class="avatar avatar-lg">
								<img class="media-object" src="../images/avatar/1.jpg" alt="Generic placeholder image">
								<i></i>
							  </span>
							</div>
							<div class="media-body w-100">
							  <h6 class="list-group-item-heading">Kristopher Candy
								<span class="float-right pt-1">$1,021</span>
							  </h6>
							  <p class="list-group-item-text mt-5 mb-0">
								<span class="badge badge-primary">Electronics</span>
								<span class="badge badge-warning ml-1">Decor</span>
							  </p>
							</div>
						  </a>
						  <a href="#" class="media xs-media p-5">
							<div class="media-left pr-1">
							  <span class="avatar avatar-lg">
								<img class="media-object" src="../images/avatar/2.jpg" alt="Generic placeholder image">
								<i></i>
							  </span>
							</div>
							<div class="media-body w-100">
							  <h6 class="list-group-item-heading">Lawrence Fowler
								<span class="float-right pt-1">$2,021</span>
							  </h6>
							  <p class="list-group-item-text mt-5 mb-0">
								<span class="badge badge-danger">Appliances</span>
							  </p>
							</div>
						  </a>
						  <a href="#" class="media xs-media p-5">
							<div class="media-left pr-1">
							  <span class="avatar avatar-lg">
								<img class="media-object" src="../images/avatar/3.jpg" alt="Generic placeholder image">
								<i></i>
							  </span>
							</div>
							<div class="media-body w-100">
							  <h6 class="list-group-item-heading">Linda Olson
								<span class="float-right pt-1">$1,112</span>
							  </h6>
							  <p class="list-group-item-text mt-5 mb-0">
								<span class="badge badge-primary">Electronics</span>
								<span class="badge badge-success ml-1">Office</span>
							  </p>
							</div>
						  </a>
						  <a href="#" class="media xs-media p-5">
							<div class="media-left pr-1">
							  <span class="avatar avatar-lg">
								<img class="media-object" src="../images/avatar/4.jpg" alt="Generic placeholder image">
								<i></i>
							  </span>
							</div>
							<div class="media-body w-100">
							  <h6 class="list-group-item-heading">Roy Clark
								<span class="float-right pt-1">$2,815</span>
							  </h6>
							  <p class="list-group-item-text mt-5 mb-0">
								<span class="badge badge-warning">Decor</span>
								<span class="badge badge-danger ml-1">Appliances</span>
							  </p>
							</div>
						  </a>
						  <a href="#" class="media xs-media p-5">
							<div class="media-left pr-1">
							  <span class="avatar avatar-lg">
								<img class="media-object" src="../images/avatar/5.jpg" alt="Generic placeholder image">
								<i></i>
							  </span>
							</div>
							<div class="media-body w-100">
							  <h6 class="list-group-item-heading">Kristopher Candy
								<span class="float-right pt-1">$2,021</span>
							  </h6>
							  <p class="list-group-item-text mt-5 mb-0">
								<span class="badge badge-primary">Electronics</span>
								<span class="badge badge-warning ml-1">Decor</span>
							  </p>
							</div>
						  </a>
						  <a href="#" class="media xs-media p-5">
							<div class="media-left pr-1">
							  <span class="avatar avatar-lg">
								<img class="media-object" src="../images/avatar/6.jpg" alt="Generic placeholder image">
								<i></i>
							  </span>
							</div>
							<div class="media-body w-100">
							  <h6 class="list-group-item-heading">Lawrence Fowler
								<span class="float-right pt-1">$1,321</span>
							  </h6>
							  <p class="list-group-item-text mt-5 mb-0">
								<span class="badge badge-danger">Appliances</span>
							  </p>
							</div>
						  </a>
						  </div>
					  </div>
					</div>
				</div>
				<div class="col-12">
					<div class="box">
					  <div class="box-header with-border">
						<h4 class="box-title">Weekly Status</h4>
					  </div>

					  <div class="box-body">

						  <div class="row">
							<div class="col-12 col-lg-9">
								<div id="stacked-column" style="height:400px;"></div>
							</div>
							<div class="col-12 col-lg-3">
							  <h3 class="text-center mb-15">Goal Completion</h3>

							  <div class="progress-group mb-40">
								<span class="progress-text">Add Products to Bag</span>
								<span class="progress-number"><b>140</b>/200</span>

								<div class="progress h-30">
								  <div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated" style="width: 70%;"></div>
								</div>
							  </div>
							  <!-- /.progress-group -->
							  <div class="progress-group mb-40">
								<span class="progress-text">Complete Purchase</span>
								<span class="progress-number"><b>300</b>/400</span>

								<div class="progress h-30">
								  <div class="progress-bar progress-bar-danger progress-bar-striped progress-bar-animated" style="width: 75%"></div>
								</div>
							  </div>
							  <!-- /.progress-group -->
							  <div class="progress-group mb-40">
								<span class="progress-text">Visit Page</span>
								<span class="progress-number"><b>400</b>/800</span>

								<div class="progress h-30">
								  <div class="progress-bar progress-bar-success progress-bar-striped progress-bar-animated" style="width: 50%"></div>
								</div>
							  </div>
							  <!-- /.progress-group -->
							  <div class="progress-group mb-40">
								<span class="progress-text">Send Inquiries</span>
								<span class="progress-number"><b>425</b>/500</span>

								<div class="progress h-30">
								  <div class="progress-bar progress-bar-warning progress-bar-striped progress-bar-animated" style="width: 85%"></div>
								</div>
							  </div>
							  <!-- /.progress-group -->
							</div>
						  </div>

						  <div class="row mt-30">
							<div class="col-6 col-md-3">
							  <div class="description-block">
								<span class="text-success"><i class="fa fa-caret-up"></i> <span class="countnm per">17</span></span>
								<h5 class="description-header">$3,249.43</h5>
								<span class="description-text">TOTAL REVENUE</span>
							  </div>
							  <!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-6 col-md-3">
							  <div class="description-block">
								<span class="text-warning"><i class="fa fa-caret-left"></i> <span class="countnm per">70</span></span>
								<h5 class="description-header">$2,376.90</h5>
								<span class="description-text">TOTAL COST</span>
							  </div>
							  <!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-6 col-md-3">
							  <div class="description-block">
								<span class="text-primary"><i class="fa fa-caret-up"></i> <span class="countnm per">80</span></span>
								<h5 class="description-header">$1,795.53</h5>
								<span class="description-text">TOTAL PROFIT</span>
							  </div>
							  <!-- /.description-block -->
							</div>
							<!-- /.col -->
							<div class="col-6 col-md-3">
							  <div class="description-block">
								<span class="text-danger"><i class="fa fa-caret-down"></i> <span class="countnm per">28</span></span>
								<h5 class="description-header">1800</h5>
								<span class="description-text">GOAL COMPLETIONS</span>
							  </div>
							  <!-- /.description-block -->
							</div>
						  </div>
					  </div>
					</div>
				</div>
			</div>
			
		</section>
		<!-- /.content -->
	  </div>
  </div>
  <!-- /.content-wrapper -->
@endsection