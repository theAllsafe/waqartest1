@extends('admin.include.layout')
@section('mainarea')
<!-- jQuery 3 -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
	
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
					<h3 class="page-title">Authentication</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Authentication</li>
								<li class="breadcrumb-item active" aria-current="page">Create Student</li>
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
					<h4 class="box-title">Create Student</h4>  
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
				    <form novalidate action="{{ url('partner/student/store') }}" method="POST" enctype="multipart/form-data">
				        @csrf
				    <div class="form-group row">
						<label class="col-form-label col-md-2">Select Institute  *</label>
						<div class="col-md-10">
						    <div class="controls">
						        <select class="form-control" name="school_id" required data-validation-required-message="This field is required">
						        @foreach($school as $row)
							    <option value="{{$row->id}}">{{$row->name}}</option>
							    @endforeach
							    </select>
						    </div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-form-label col-md-2">Session *</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select class="form-control" name="session" required data-validation-required-message="This field is required">
						        @foreach($session as $row)
							    <option>{{$row->session}}</option>
							    @endforeach
							    </select>
						    </div>
						</div>
						<label class="col-form-label col-md-2">Choose Category</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select onchange="getStateWiseCategory(this.value);" class="form-control" name="category_id" required data-validation-required-message="This field is required">
    						        <option value="">Select Category</option>
    						        @foreach($category as $row)
    							    <option value="{{$row->id}}">{{$row->category_name}}</option>
    							    @endforeach
							    </select>
						    </div>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-md-2">Choose Class</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select onchange="getStateWiseCity(this.value);" class="getclass_id form-control" name="class" required data-validation-required-message="This field is required">
						        
							    </select>
						    </div>
						</div>
						<label class="col-form-label col-md-2">Choose Section</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select class="form-control" name="section" required data-validation-required-message="This field is required">
						            <option value="">Select Section</option>
    						        @foreach($Section as $row)
    							    <option value="{{$row->id}}">{{$row->section_name}}</option>
    							    @endforeach
							    </select>
						    </div>
						</div>
					</div>
					

					<div class="form-group row">
						<label class="col-form-label col-md-2">Student Name</label>
						<div class="col-md-4">
						    <div class="controls">
							<input class="form-control" type="text" name="name" required data-validation-required-message="This field is required">
						    </div>
						</div>
						<label class="col-form-label col-md-2">Email( login id)</label>
						<div class="col-md-4">
							<div class="controls">
								<input type="email" name="email" class="form-control" required data-validation-required-message="This field is required"> 
							</div>
						</div>
					</div>
	
					<div class="form-group row">
						<label class="col-form-label col-md-2">Student Contact Number</label>
						<div class="col-md-4">
							<div class="controls">
								<input type="number" name="contact_number" class="form-control"> 
							</div>
						</div>
						<label class="col-form-label col-md-2">ID / Enrollment No. / Roll No.</label>
						<div class="col-md-4">
							<div class="controls">
								<input type="number" name="enrollment_number" class="form-control"> 
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label>Uploade Image</label>
						<input type="file" name="image" class="form-control" placeholder="About School">
					</div>
					<div class="form-group">
						<label>About</label>
						<textarea rows="5" cols="5" class="form-control" name="about" placeholder="About"></textarea>
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
		  <form action="{{ url('partner/import/store') }}" method="POST" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="box-body">
			    @csrf
			    <div class="form-group row">
					<label class="col-form-label col-md-2">Institute</label>
					<div class="col-md-10">
					    <div class="controls">
					        <select class="form-control" name="school_id" required data-validation-required-message="This field is required">
					        <option value="">Select Institute</option>
					        @foreach($school as $row)
						    <option value="{{$row->id}}">{{$row->name}}</option>
						    @endforeach
						    </select>
					    </div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-2">Session</label>
					<div class="col-md-10">
					    <div class="controls">
					        <select class="form-control" name="session" required data-validation-required-message="This field is required">
					        <option value="">Select Session</option>
					        @foreach($session as $row)
						    <option>{{$row->session}}</option>
						    @endforeach
						    </select>
					    </div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-md-2">Category</label>
					<div class="col-md-10">
					    <div class="controls">
					        <select onchange="getStateWiseCategory(this.value);" class="form-control" name="category_id" required data-validation-required-message="This field is required">
						        <option value="">Select Category</option>
						        @foreach($category as $row)
							    <option value="{{$row->id}}">{{$row->category_name}}</option>
							    @endforeach
						    </select>
					    </div>
					</div>
				</div>
				
				<div class="form-group row">
						<label class="col-form-label col-md-2">Class</label>
						<div class="col-md-10">
						    <div class="controls">
						        <select onchange="getStateWiseCity(this.value);" class="getclass_id form-control" name="class" required data-validation-required-message="This field is required">
						        
							    </select>
						    </div>
						</div>
				</div>

				<div class="form-group row">
						<label class="col-form-label col-md-2">Section</label>
						<div class="col-md-10">
						    <div class="controls">
						        <select class="form-control" name="section" required>
						            <option value="">Select Section</option>
    						        @foreach($Section as $row)
    							    <option value="{{$row->id}}">{{$row->section_name}}</option>
    							    @endforeach
							    </select>
						    </div>
						</div>
					</div>
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
		    <a href="{{ url('example.csv') }}" download class="btn btn-outline btn-success mb-5">Download Example</a>
			<button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-bold btn-pure btn-primary float-right">Save</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
  <!-- /.modal -->
  <script>
   function getStateWiseCategory(id)
    {
        var state = id;
        // alert(state);
        $.ajax({
            type: "Get",
            url: "getclass",
            data: {id: state},
            success: function (response) { //alert(response);
                $(".getclass_id").html(response);
            }
        });
    }
   function getStateWiseCity(id)
    {
        var state = id;
        // alert(state);
        $.ajax({
            type: "Get",
            url: "getsection",
            data: {id: state},
            success: function (response) { //alert(response);
                $("#section_id").html(response);
            }
        });
    }
    </script>
@endsection