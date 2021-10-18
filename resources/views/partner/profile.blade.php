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
					<h3 class="page-title">Setting</h3>
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
				</div>
			</div>
		</div>

		<!-- Main content -->
		<section class="content">

		  <div class="row">
			<div class="col-lg-6 connectedSortable ui-sortable">
			  <!-- Default box -->
			  <div class="box">
				<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
				  <h4 class="box-title">Profile Management</h4>

				  <ul class="box-controls pull-right">
					<li><a class="box-btn-close" href="#"></a></li>
					<li><a class="box-btn-slide" href="#"></a></li>	
				  </ul>
				</div>
				<div class="box-body p-0">
				    @if(session()->has('status'))
            		<div class="alert alert-info">
            				{{ session()->get('status') }}
            			</div>
            		@endif
				  <ul class="todo-list ui-sortable">
					<li class="p-15">
					  <div class="box p-15 mb-0 d-block bb-2 border-secondary">
						 <!-- drag handle -->
						  <form novalidate action="{{ url('partner/updateprofile') }}" method="POST" enctype="multipart/form-data">
        				        @csrf
        					<div class="form-group row">
        						<label class="col-form-label col-md-2">Name</label>
        						<div class="col-md-10">
        						    <div class="controls">
        							<input class="form-control" type="text" name="name" required data-validation-required-message="This field is required">
        						    </div>
        						</div>
        					</div>
        
        					<div class="form-group row">
        						<label class="col-form-label col-md-2">Email</label>
        						<div class="col-md-10">
        							<div class="controls">
        								<input type="email" name="email" class="form-control" required data-validation-required-message="This field is required"> 
        							</div>
        						</div>
        					</div>	
        					<div class="form-group row">
        						<label class="col-form-label col-md-2">Profile image</label>
        						<div class="col-md-10">
        							<div class="controls">
        								<input type="file" name="image" class="form-control" required data-validation-required-message="This field is required"> 
        							</div>
        						</div>
        					</div>	
        					<div class="text-xs-left">
        						<button type="submit" class="btn btn-info">Update</button>
        					</div>
        				</form>
					  </div>
					</li>
				  </ul>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<div class="col-lg-6 connectedSortable ui-sortable">
			  <!-- Default box -->
			  <div class="box">
				<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
				  <h4 class="box-title">Change Password</h4>

				  <ul class="box-controls pull-right">
					<li><a class="box-btn-close" href="#"></a></li>
					<li><a class="box-btn-slide" href="#"></a></li>	
				  </ul>
				</div>
				<div class="box-body p-0">
				    @if(session()->has('change_password_status'))
            		<div class="alert alert-info">
            				{{ session()->get('change_password_status') }}
            			</div>
            		@endif
				  <ul class="todo-list ui-sortable">
					<li class="p-15">
					  <div class="box p-15 mb-0 d-block bb-2 border-danger">
						 <form novalidate action="{{ url('partner/changepassword') }}" method="POST">
        				        @csrf
        					<div class="form-group row">
        						<label class="col-form-label col-md-2">Old password</label>
        						<div class="col-md-10">
        						    <div class="controls">
        							<input class="form-control" type="password" name="old_password" required data-validation-required-message="This field is required">
        						    </div>
        						</div>
        					</div>
        
        					<div class="form-group row">
        						<label class="col-form-label col-md-2">New password</label>
        						<div class="col-md-10">
        							<div class="controls">
        								<input type="password" name="new_password" class="form-control" required data-validation-required-message="This field is required"> 
        							</div>
        						</div>
        					</div>	
        					<div class="form-group row">
        						<label class="col-form-label col-md-2">Confirm password</label>
        						<div class="col-md-10">
        							<div class="controls">
        								<input type="password" name="confirm_password" class="form-control" required data-validation-required-message="This field is required"> 
        							</div>
        						</div>
        					</div>	
        					<div class="text-xs-left">
        						<button type="submit" class="btn btn-info">Update</button>
        					</div>
        				</form>
					  </div>
					</li>
				  </ul>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
			<div class="col-lg-6 connectedSortable ui-sortable">
			  <!-- Default box -->
			  <div class="box">
				<div class="box-header with-border ui-sortable-handle" style="cursor: move;">
				  <h4 class="box-title">Upload Institute image</h4>

				  <ul class="box-controls pull-right">
					<li><a class="box-btn-close" href="#"></a></li>
					<li><a class="box-btn-slide" href="#"></a></li>	
				  </ul>
				</div>
				<div class="box-body p-0">
				    @if(session()->has('instituteimage_status'))
            		<div class="alert alert-info">
            				{{ session()->get('instituteimage_status') }}
            			</div>
            		@endif
				  <ul class="todo-list ui-sortable">
					<li class="p-15">
					  <div class="box p-15 mb-0 d-block bb-2 border-success">
						 <form novalidate action="{{ url('partner/instituteimage') }}" method="POST" enctype="multipart/form-data">
        				        @csrf	
        				        <?php $data=DB::table('tbl_partner')->where('partner_id',Auth::user()->id)->first(); ?>
                                 
                            
                            <div class="form-group row">
        						<div class="col-md-12">
        							<div class="controls">
        								<img src="@if($data->institute_image) {{ URL::asset('admin_assets/upload') }}/{{$data->institute_image}} @else {{ URL::asset('admin_assets/images/user-info.jpg') }} @endif" class="user-image" alt="instituteimage">
        							</div>
        						</div>
        					</div>
                            <div class="form-group row">
        						<label class="col-form-label col-md-2">Institute image</label>
        						<div class="col-md-10">
        							<div class="controls">
        								<input type="file" name="institute_image" class="form-control" required data-validation-required-message="This field is required"> 
        							</div>
        						</div>
        					</div>	
        					<div class="text-xs-left">
        						<button type="submit" class="btn btn-info">Update</button>
        					</div>
        				</form>
					  </div>
					</li>

				  </ul>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>
		  </div>
		</section>
		<!-- /.content -->
	  </div>
  </div>
  <!-- /.content-wrapper -->
    <script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
<script src="{{ URL::asset('admin_assets/js/pages/validation.js') }}"></script>
<script src="{{ URL::asset('admin_assets/js/pages/form-validation.js') }}"></script>
@endsection