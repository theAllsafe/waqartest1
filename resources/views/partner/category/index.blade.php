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
								<li class="breadcrumb-item active" aria-current="page">Category List</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="right-title">
				    <button data-toggle="modal" data-target="#modal-center" class="btn btn-outline btn-success mb-5">Add Category</button>
				</div>
			</div>
		</div>

		<!-- Main content -->
		<section class="content">
		  <div class="row">
			  
			<div class="col-12">
				<div class="box">
					<div class="box-header">						
						<h4 class="box-title">Category List</h4>
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
										<th>Id</th>
										<th>Category</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>@foreach($users as $key => $value)
									<tr>
										<td>{{++$key}}</td>
										<td>{{$value->category_name}}</td>
										<td><a class="btn btn-outline btn-success mb-5" href="{{ url('admin/category/edit') }}/{{$value->id}}"><i class="fa fa-edit"></i></a>
                    						<a class="btn btn-outline btn-success mb-5" href="{{ url('admin/category/destroy') }}/{{$value->id}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash-o"></i></a>
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
  <!-- /.content-wrapper -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js') }}"></script>
	
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/jquery-ui/jquery-ui.js') }}"></script>
	
	<!-- popper -->
	<script src="{{ URL::asset('admin_assets/assets/vendor_components/popper/dist/popper.min.js') }}"></script>
<!-- Modal -->
  <div class="modal center-modal fade" id="modal-center" tabindex="-1">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title">Category</h5>
			<button type="button" class="close" data-dismiss="modal">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form novalidate action="{{ url('admin/category/store') }}" method="POST">
		  <div class="modal-body">
			<div class="box-body">
			    @csrf
				<div class="form-group row">
					<label class="col-form-label col-md-2">Category</label>
					<div class="col-md-8">
					    <div class="controls">
						<input class="form-control" type="text" name="category[]" required data-validation-required-message="This field is required">
					    </div>
					</div>
					<div class="col-md-1">
					    <div class="controls">
						<i class="fa fa-plus" class="form-control mb-2" id="add-pricing"></i>
					    </div>
					</div> 
				</div>
				<div id='pricing-row'>	                                   
				</div>
			</div>
		  </div>
		  <div class="modal-footer modal-footer-uniform">
			<button type="button" class="btn btn-bold btn-pure btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-bold btn-pure btn-primary float-right">Save</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
  <!-- /.modal -->
  <script type="text/javascript">
	$(document).ready(function(){ 
	    $('.category').on('change', function() {
        if(this.value==8){
            $("#add-pricing").show();
        }else{
            $("#add-pricing").hide();
        }
        });
		var incr=2;
		$(document).on('click','#add-pricing',function(){
		  //  alert('hello');
			var pricingTable = `
				<div class="form-group row" id="pricing-${incr}">
					<label class="col-form-label col-md-2">Category</label>
					<div class="col-md-8">
					    <div class="controls">
						<input class="form-control" type="text" name="category[]" required data-validation-required-message="This field is required">
					    </div>
					</div>
					<div class="col-md-1">
					    <div class="controls">
						<i class="fa fa-minus" id="delete-pricing" data-id="${incr}"></i>
					    </div>
					</div> 
				</div>
			`;
			$("#pricing-row").append(pricingTable);
			incr++;

		});
		$(document).on('click','#delete-pricing',function(){
			var id = $(this).attr("data-id");
			$(this).closest("#pricing-"+id).remove();
		});
	});
</script>
@endsection