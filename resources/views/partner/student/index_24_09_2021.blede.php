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
				  <h3 class="box-title">Individual column searching</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  <table id="example5" class="table table-bordered table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Name of Student	</th>
								<th>Email Address	</th>
								<th>Contact Number	</th>
								<th>About		</th>
								<th>Action</th>
								<th>Status	</th>
							</tr>
						</thead>
						<tbody>@foreach($users as $key => $value)
							<tr>
								<td>{{$value->name}}</td>
								<td>{{$value->email}}</td>
								<td>{{$value->mobile_number}}</td>
								<td>{{$value->about}}</td>
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
$(document).ready(function() {
    $('#exampleee').DataTable( {
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
 </script>
@endsection