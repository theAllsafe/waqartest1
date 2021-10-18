@extends('admin.include.layout')
@section('mainarea')
<div class="content-wrapper" style="min-height: 1823.48px;">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="page-title">Student</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">Student</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Student</li>
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
					<h4 class="box-title">Edit Student</h4>  
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
				    <form novalidate action="{{ url('partner/student/update/') }}/{{$student['id']}}" method="POST" enctype="multipart/form-data">
				        {{csrf_field()}}
                        {{method_field('PUT')}}
					<div class="form-group row">
						<label class="col-form-label col-md-2">Select Institute  *</label>
						<div class="col-md-10">
						    <div class="controls">
						        <select class="form-control" name="school_id" required data-validation-required-message="This field is required">
						        @foreach($school as $row)
							    <option value="{{$row->id}}" @if($row->id==$student['school_id']) selected @endif>{{$row->name}}</option>
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
							    <option @if($row->session==$student['session']) selected @endif>{{$row->session}}</option>
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
    							    <option value="{{$row->id}}" @if($row->id==$student['category_id']) selected @endif>{{$row->category_name}}</option>
    							    @endforeach
							    </select>
						    </div>
						</div>
					</div>
					
					<div class="form-group row">
						<label class="col-form-label col-md-2">Choose Class</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select onchange="getStateWiseCity(this.value);" id="getclass_id"  class="form-control" name="class" required data-validation-required-message="This field is required">
						            <option value="{{$student['class_id']}}">{{$student['class']}}</option>
							    </select>
						    </div>
						</div>
						<label class="col-form-label col-md-2">Choose Section</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select class="form-control" name="section" required data-validation-required-message="This field is required">
						            <option value="">Select Section</option>
    						        @foreach($section as $row)
    							    <option value="{{$row->id}}"  @if($row->id==$student['section_id']) selected @endif>{{$row->section_name}}</option>
    							    @endforeach
							    </select>
						    </div>
						</div>
					</div>
					
					<div class="form-group row">
						
					</div>

					<div class="form-group row">
						<label class="col-form-label col-md-2">Student Name</label>
						<div class="col-md-4">
						    <div class="controls">
							<input class="form-control" value="{{$student['name']}}" type="text" name="name" required data-validation-required-message="This field is required">
						    </div>
						</div>
						<label class="col-form-label col-md-2">Email( login id)</label>
						<div class="col-md-4">
							<div class="controls">
								<input type="email" value="{{$student['email']}}" name="email" class="form-control" required data-validation-required-message="This field is required"> 
							</div>
						</div>
					</div>
	
					<div class="form-group row">
						<label class="col-form-label col-md-2">Student Contact Number</label>
						<div class="col-md-4">
							<div class="controls">
								<input type="number" value="{{$student['mobile_number']}}" name="contact_number" class="form-control"> 
							</div>
						</div>
						<label class="col-form-label col-md-2">ID / Enrollment No. / Roll No.</label>
						<div class="col-md-4">
							<div class="controls">
								<input type="number" value="{{$student['enrollment_number']}}" name="enrollment_number" class="form-control"> 
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label>Uploade Image</label>
						<input type="file" name="image" class="form-control">
						<input type="hidden" value="{{$student['image']}}" name="oldimage">
					</div>
					<div class="form-group">
						<label>About</label>
						<textarea rows="5" cols="5" class="form-control" name="about" placeholder="About">{{$student['about']}}</textarea>
					</div>
					<div class="text-xs-right">
						<button type="submit" class="btn btn-info">Update</button>
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
 <script>
   function getStateWiseCategory(id)
    {
        var state = id;
        // alert(state);
        $.ajax({
            type: "Get",
            url: "https://scsy.in/schoolbuddy/schoolbuddy/public/partner/student/getclass",
            data: {id: state},
            success: function (response) { //alert(response);
                $("#getclass_id").html(response);
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