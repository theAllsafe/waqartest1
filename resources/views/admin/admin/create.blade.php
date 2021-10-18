@extends('admin.include.layout')
@section('mainarea')
<div class="content-wrapper" style="min-height: 1823.48px;">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="page-title">Authentication</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Authentication</li>
								<li class="breadcrumb-item active" aria-current="page">Create Admin</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
        
		<!-- Main content -->
		<section class="content">

		  <div class="row">

			<div class="col-12">
			  <div class="box">
				  
				<div class="box-header">
					<h4 class="box-title">Create Admin</h4>  
				</div>
				@if(session()->has('status'))
        		<div class="alert alert-info">
        				{{ session()->get('status') }}
        			</div>
        		@endif
        		@if($errors->has('email'))
        		<div class="alert alert-danger">
    				{{ $errors->first('email') }}
    			</div>
        		@endif
				<div class="box-body">
				    <form novalidate action="{{ url('admin/admin/store') }}" method="POST">
				        @csrf
					<div class="form-group row">
						<label class="col-form-label col-md-2">Name</label>
						<div class="col-md-10">
						    <div class="controls">
							<input class="form-control" type="text" name="name" placeholder="Name" required data-validation-required-message="This field is required">
						    </div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-md-2">Email( login id)</label>
						<div class="col-md-10">
							<div class="controls">
								<input type="email" name="email" class="form-control" required data-validation-required-message="This field is required"> 
							</div>
						</div>
					</div>	
					<div class="text-xs-right">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
					</form>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<!-- ./col -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  </div>
  </div>
  <script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
<script src="{{ URL::asset('admin_assets/js/pages/validation.js') }}"></script>
<script src="{{ URL::asset('admin_assets/js/pages/form-validation.js') }}"></script>
@endsection