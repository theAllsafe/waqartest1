@extends('admin.include.layout')
@section('mainarea')
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
								<li class="breadcrumb-item active" aria-current="page">Admin List</li>
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
						<h4 class="box-title">Admin List</h4>
					</div>
					@if(session()->has('status'))
            		<div class="alert alert-info">
            				{{ session()->get('status') }}
            			</div>
            		@endif
					<div class="box-body">
						<div class="table-responsive">
							<table id="example1" class="table table-striped table-bordered display" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Email( login id)</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>@foreach($users as $key => $value)
									<tr>
										<td>{{++$key}}</td>
										<td>{{$value->name}}</td>
										<td>{{$value->email}}</td>
										<td>
                    						<a class="btn btn-outline btn-success mb-5" href="{{ url('admin/admin/destroy') }}/{{$value->id}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
                    					    <a class="btn btn-outline btn-success mb-5" href="{{ url('partner/student/show') }}/{{$value->id}}"><i class="fa fa-eye"></i></a>
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
<link rel="stylesheet" type="text/css" href="{{ URL::asset('admin_assets/assets/vendor_components/datatable/datatables.min.css') }}"/>
<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
<script src="{{ URL::asset('admin_assets/assets/vendor_components/datatable/datatables.min.js') }}"></script>
<script src="{{ URL::asset('admin_assets/js/pages/data-table.js') }}"></script>
<script>
    $(document).ready( function () {
        $('#example1').DataTable();
    } );
</script>
@endsection