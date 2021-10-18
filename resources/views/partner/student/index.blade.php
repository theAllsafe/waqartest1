@extends('admin.include.layout')
@section('mainarea')
<!-- Data Table-->
	<!-- jQuery 3 -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
	
	<!-- popper -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
<script src="{{ URL::asset('admin_assets/assets/vendor_components/datatable/datatables.min.js') }}"></script>
<script src="{{ URL::asset('admin_assets/js/pages/data-table.js') }}"></script>
	
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="page-title">List</h3>
					<div class="d-inline-block align-items-center">
						<nav>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
								<li class="breadcrumb-item" aria-current="page">List</li>
								<li class="breadcrumb-item active" aria-current="page">Student List</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="right-title">
				    <a href="{{ url('partner/student/create') }}" class="btn btn-outline btn-success mb-5">Add Student</a>
				</div>
			</div>
		</div>

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			  <div class="col-12">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Student List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				    <div class="form-group row">
						<label class="col-form-label col-md-2">Select Institute  *</label>
						<div class="col-md-10">
						    <div class="controls">
						        <select class="form-control search" id="search_institute" name="school_id" required data-validation-required-message="This field is required">
						        <option value="">Select Institute</option>
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
						        <select class="form-control search" id="search_session" name="session" required data-validation-required-message="This field is required">
						        <option value="">Select Session</option>
						        @foreach($session as $row)
							    <option>{{$row->session}}</option>
							    @endforeach
							    </select>
						    </div>
						</div>
						<label class="col-form-label col-md-2">Choose Category</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select onchange="getStateWiseCategory(this.value);" id="search_category" class="form-control search" name="category_id" required data-validation-required-message="This field is required">
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
						        <select onchange="getStateWiseCity(this.value);"  id="getclass_id"  class="form-control search" name="class" required data-validation-required-message="This field is required">
						        
							    </select>
						    </div>
						</div>
						<label class="col-form-label col-md-2">Choose Section</label>
						<div class="col-md-4">
						    <div class="controls">
						        <select class="form-control search" name="section" id="search_section" required data-validation-required-message="This field is required">
						            <option value="">Select Section</option>
    						        @foreach($Section as $row)
    							    <option value="{{$row->id}}">{{$row->section_name}}</option>
    							    @endforeach
							    </select>
						    </div>
						</div>
					</div>
					<div class="table-responsive">
					  <table id="example" class="table table-bordered table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Name of Student	</th>
								<th>Email Address	</th>
								<th>Contact Number	</th>
								<th>Category		</th>
								<th>Institute Name	</th>
            					<th>Stage / Class / Year</th>
        					    <th>Session	</th>
            					<th>Section		</th>
								<th>Action</th>
								<th>Status	</th>
							</tr>
						</thead>
						<tbody id="tbl-data">@foreach($users as $key => $value)
							<tr>
								<td>{{$value->name}}</td>
								<td>{{$value->email}}</td>
								<td>{{$value->mobile_number}}</td>
								<td>{{$value->category_name}}</td>
        						<td>{{$value->school_name}}</td>
        						<td>{{$value->class}}</td>
        					    <td>{{$value->session}}</td>
        						<td>{{$value->section_name}}</td>
								<td><a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/edit') }}/{{$value->id}}"><i class="fa fa-edit"></i></a>
            						<a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/destroy') }}/{{$value->id}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
            						<a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/show') }}/{{$value->id}}"><i class="fa fa-eye"></i></a>
            					</td>
            					<td>
            					    <select class="change_status login_status-{{$value->id}}" data-id="{{$value->id}}">
            					    <option value="1" @if($value->login_status==1) selected @endif>Enable</option>
            					    <option value="0" @if($value->login_status==0) selected @endif>Disable</option>
            					    </select>
            					</td>
							</tr>@endforeach
						</tbody>
					</table>
					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->      
			</div> 
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
	  </div>
  </div>
  <!-- /.content-wrapper -->
  <script>
 $(document).ready(function(){
    
    
    $('.search').on('change',function(){
        var search_institute = $('#search_institute').val(); 
        var search_session = $('#search_session').val(); 
        var search_category = $('#search_category').val(); 
        var getclass_id = $('#getclass_id').val(); 
        var search_section = $('#search_section').val(); 
        // alert(search_institute+search_session+search_category+getclass_id+search_section);
        var tbl_str 	= '';
        $.ajax({
        type: "get",
        dataType: "json",
        url: "{{ URL::asset('partner/student') }}",
        data: { _token:'{{ csrf_token() }}','search_institute':search_institute,'search_session':search_session,'search_category':search_category,'getclass_id':getclass_id,'search_section':search_section},

        success: function (response) {
            $.each(response,function(key,value){
                console.log(value.id);
                tbl_str += '<tr><td>'+value.name+'</td><td>'+value.email+'</td><td>'+value.mobile_number+'</td><td>'+value.category_name+'</td><td>'+value.school_name+'</td><td>'+value.class+'</td><td>'+value.session+'</td><td>'+value.section_name+'</td><td><a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/edit') }}/'+value.id+'"><i class="fa fa-edit"></i></a><a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/destroy') }}/'+value.id+'" onclick="return confirm("Are you sure you want to delete this item?");"><i class="fa fa-trash-o"></i></a><a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/show') }}/'+value.id+'"><i class="fa fa-eye"></i></a></td><td><select class="change_status login_status-'+value.id+'" data-id="'+value.id+'"><option value="1">Enable</option><option value="0">Disable</option></select></td></tr>';
				
            });
            $('#tbl-data').html(tbl_str);
           
        }
        });
    	
    });
     $('.change_status').on('change',function(){
        var id = $(this).attr("data-id"); 
        var status = $('.login_status-'+id).val();
        // alert(id+status);
        $.ajax({
        type: "post",
        dataType: "json",
        url: "{{ URL::asset('admin/partner/status') }}",
        data: { _token:'{{ csrf_token() }}','id':id,'status':status},

        success: function (response) {
           if(response=='0')
		    {
		        alert("Status update successfully");
			    location.reload();  
		    }
		    else{
		        alert("Status not update");
		    }
        }
        });
    	
    });
 });
</script>
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
    </script>
@endsection