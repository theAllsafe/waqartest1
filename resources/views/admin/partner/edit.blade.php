@extends('admin.include.layout')
@section('mainarea')
<div class="content-wrapper" style="min-height: 1823.48px;">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="page-title">Institute</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Institute</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Institute</li>
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
					<h4 class="box-title">Edit Institute</h4>  
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
				    <form novalidate action="{{ url('admin/partner/update/') }}/{{$school['id']}}" method="POST" enctype="multipart/form-data">
				        {{csrf_field()}}
                        {{method_field('PUT')}}
					<div class="form-group row">
    						<label class="col-form-label col-md-2">Name of Institute*</label>
    						<div class="col-md-10">
    						    <div class="controls">
    							<input class="form-control" type="text" name="name" value="{{$school['name']}}" placeholder="Name of Institute*" required data-validation-required-message="This field is required">
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
                							<input class="form-control" type="text" value="{{$school['email']}}" name="email" placeholder="E-mail Address *"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
            						<div class="form-group row">
                						<label class="col-form-label col-md-3">Mobile Number *</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['mobile_number']}}" name="mobile_number" placeholder="Mobile Number *"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">Telephone Number	</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['telephone_number']}}" name="telephone_number" placeholder="Telephone Number"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">Fax Number</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['fax_number']}}" name="fax_number" placeholder="Fax Number"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div><hr>
            						<div class="form-group">
                						<label>Uploade Image</label>
                						<input type="file" name="image" class="form-control">
                						<input type="hidden" value="{{$school['image']}}" name="oldimage">
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
                							<input class="form-control" type="text" value="{{$school['address_line_1']}}" name="address_line_1" placeholder="Address Line 1"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
            						<div class="form-group row">
                						<label class="col-form-label col-md-3"></label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['address_line_2']}}" name="address_line_2" placeholder="Address Line 2">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">City	</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['city']}}" name="city" placeholder="City"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">State/ Province/ Region </label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['state']}}" name="state" placeholder="State/ Province/ Region"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">ZIP/ Postal Code *</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['zip']}}" name="zip" placeholder="ZIP/ Postal Code *	"  required data-validation-required-message="This field is required">
                						    </div>
                						</div>
                					</div>
                					<div class="form-group row">
                						<label class="col-form-label col-md-3">Country</label>
                						<div class="col-md-9">
                						    <div class="controls">
                							<input class="form-control" type="text" value="{{$school['country']}}" name="country" placeholder="Country"  required data-validation-required-message="This field is required">
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
						<textarea rows="5" cols="5" class="form-control" name="about_school" placeholder="About School">{{$school['about']}}</textarea>
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