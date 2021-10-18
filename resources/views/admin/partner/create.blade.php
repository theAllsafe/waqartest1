@extends('admin.include.layout')
@section('mainarea')
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-ui/jquery-ui.js') }}"></script>
	
	<!-- popper -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
<div class="content-wrapper" style="min-height: 1823.48px;">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="page-title">School</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">School</li>
								<li class="breadcrumb-item active" aria-current="page">Add School</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="right-title">
				    <button type="submit" class="btn btn-outline btn-success mb-5" data-toggle="modal" data-target="#modal-center">Import Data</button>
				</div>
			</div>
		</div>
        
		<!-- Main content -->
		<section class="content">

		  <div class="row">

			<div class="col-12">
			  <div class="box">
				  
				<div class="box-header">
					<h4 class="box-title">Add School</h4>  
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
				    <form novalidate action="{{ url('admin/partner/store') }}" method="POST" enctype="multipart/form-data">
				        @csrf
				        <div class="form-group row">
    						<label class="col-form-label col-md-2">Name of Institute*</label>
    						<div class="col-md-10">
    						    <div class="controls">
    							<input class="form-control" type="text" name="name" placeholder="Name of Institute*" required data-validation-required-message="This field is required">
    						    </div>
    						</div>
    					</div>
				        <div class="row">
            				<div class="col-xl-6 col-12">
            					<div class="box">
            					  <div class="box-header with-border">
            						<h4 class="box-title">Contact Information</h4>
            					  </div>
            
            					  <div class="box-body" style="margin-bottom: 6px;">
            						<div class="form-group row">
                						<label class="col-form-label col-md-3">E-mail Address *</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="email" placeholder="E-mail Address *"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
            						<div class="form-group row">
                						<label class="col-form-label col-md-3">Mobile Number *</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="mobile_number" placeholder="Mobile Number *"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">Telephone Number	</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="telephone_number" placeholder="Telephone Number"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">Fax Number</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="fax_number" placeholder="Fax Number"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div><hr>
            						<div class="form-group">
                						<label>Uploade Image</label>
                						<input type="file" name="image" class="form-control" placeholder="About School">
                					</div>
            					</div>
            				  </div>
            				</div>
            				<div class="col-xl-6 col-12">			
            				  <!-- Chart -->
            				  <div class="box">
            					<div class="box-header with-border">
            					  <h4 class="box-title">Address</h4>
            					</div>
            					<div class="box-body">
            						<div class="form-group row">
                						<label class="col-form-label col-md-3">Address</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="address_line_1" placeholder="Address Line 1"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
            						<div class="form-group row">
                						<label class="col-form-label col-md-3"></label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="address_line_2" placeholder="Address Line 2">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">City	</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="city" placeholder="City"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">State/ Province/ Region </label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="state" placeholder="State/ Province/ Region"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">ZIP/ Postal Code *</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="zip" placeholder="ZIP/ Postal Code *	"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">Country</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" name="country" placeholder="Country"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
            					</div>
            					<!-- /.box-body -->
            				  </div>
            				  <!-- /.box -->
            				</div>
            			</div>
					<div class="form-group">
						<label>About School	</label>
						<textarea rows="5" cols="5" class="form-control" name="about_school" placeholder="About School"></textarea>
					</div>
					<div class="text-xs-left">
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

<!-- Modal -->
  <div class="modal center-modal fade" id="modal-center" tabindex="-1">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Import Data</h5>
			<button type="button" class="close" data-dismiss="modal">
			  <span aria-hidden="true">&times;</span>
			</button>
			
		  </div>
		  <form novalidate action="{{ url('admin/partner/import') }}" method="POST" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="box-body">
			    @csrf
				<div class="form-group row">
					<div class="col-md-12">
					    <div class="controls">
						<input class="form-control" type="file" name="file" required data-validation-required-message="This field is required">
					    </div>
					</div>
				</div>
			</div>
		  </div>
		  <div class="modal-footer modal-footer-uniform">
		    <a href="{{ url('exampleP.csv') }}" download class="btn btn-outline btn-success mb-5">Download Example</a>
			<button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-bold btn-pure btn-primary float-right">Save</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
  <!-- /.modal -->
@endsection