@extends('admin.include.layout')
@section('mainarea')
<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
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
								<li class="breadcrumb-item active" aria-current="page">School List</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="right-title">
				</div>
			</div>
		</div>

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			  
			<div class="col-12">
				<div class="box">
					<div class="box-header">						
						<h4 class="box-title">School List</h4>
					</div>
					@if(session()->has('status'))
            		<div class="alert alert-info">
            				{{ session()->get('status') }}
            			</div>
            		@endif
					<div class="box-body">
						<div class="table-responsive">
							<table id="example" class="table table-bordered table-hover display nowrap margin-top-10 w-p100 dataTable" role="grid" aria-describedby="example_info">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name of Institute 	</th>
										<th>Email Address</th>
										<th>Mobile Number</th>
										<th>Telephone Number</th>
										<th>Address Line 1&2</th>
										<th>City</th>
										<th>State/ Province/ Region</th>
										<th>Zip / Postal Code	</th>
										<th>Country </th>
										<th>Action</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>@foreach($users as $key => $value)
									<tr>
										<td>{{++$key}}</td>
										<td>{{$value->name}}</td>
										<td>{{$value->email}}</td>
										<td>{{$value->mobile_number}}</td>
										<td>{{$value->telephone_number}}</td>
										<td>{{$value->address_line_1}}<br>{{$value->address_line_2}}</td>
										<td>{{$value->city}}</td>
										<td>{{$value->state}}</td>
										<td>{{$value->zip}}</td>
										<td>{{$value->country}}</td>
										<td><a class="btn btn-outline btn-success mb-5" href="{{ url('admin/partner/edit') }}/{{$value->id}}"><i class="fa fa-edit"></i></a>
                    						<a class="btn btn-outline btn-success mb-5" href="{{ url('admin/partner/destroy') }}/{{$value->id}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
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
<!-- Data Table-->
<script>
 $(document).ready(function(){
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
@endsection