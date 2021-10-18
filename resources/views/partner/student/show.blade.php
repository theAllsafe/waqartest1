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
        <section class="invoice printableArea">
			
			  <!-- info row -->
			  <div class="row invoice-info">
				<div class="col-md-9 invoice-col">
				    <div class="form-group row">
						<label class="col-form-label col-md-2">Student Name</label>
						<div class="col-md-4">
						    <div class="controls" style="margin: 7px;">
							    {{$users->name}}
						    </div>
						</div>
						<label class="col-form-label col-md-2">Email( login id)</label>
						<div class="col-md-4">
							<div class="controls" style="margin: 7px;">
								{{$users->email}}
							</div>
						</div>
					</div>
	
					<div class="form-group row">
						<label class="col-form-label col-md-2">Student Contact Number</label>
						<div class="col-md-10">
							<div class="controls" style="margin: 7px;">
								{{$users->mobile_number}}
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-md-2">About</label>
						<div class="col-md-10">
							<div class="controls" style="margin: 7px;">
								{{$users->about}}
							</div>
						</div>
					</div>
				</div>
				<!-- /.col -->
				<div class="col-md-3 invoice-col text-right">
				  <img src="{{$users->image}}" alt="logo" style="width: 72%;">
				</div>
			  </div>
			  <!-- /.row -->

			  <!-- Table row -->
			  <div class="row">
				<div class="col-12 table-responsive">
				  <table class="table table-bordered">
					<tbody>
					<tr>
    					<th>Category		</th>
    					<th>Institute Name	</th>
    					<th>Studying Status	</th>
    					<th>Stage / Class / Year		</th>
					    <th>Session	</th>
    					<th>Section		</th>
    					<th>ID / Enrollment No. / Roll No.	</th>
					</tr>@foreach($student as $key => $value)
					<tr>
						<td>{{$value->category_name}}</td>
						<td>{{$value->school_name}}</td>
						<td>{{$value->current_status}}</td>
						<td>{{$value->class}}</td>
					    <td>{{$value->session}}</td>
						<td>{{$value->section_name}}</td>
						<td>{{$value->enrollment_number}}</td>
					</tr>@endforeach
					
					</tbody>
				  </table>
				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
		</section>
	  
	  </div>
  </div>
  <!-- /.content-wrapper -->

@endsection