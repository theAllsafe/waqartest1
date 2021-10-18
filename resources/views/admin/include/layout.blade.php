<!DOCTYPE html>
<html lang="en">
  @include('admin.include.head')

<body class="skin-info sidebar-mini light-sidebar">
<div class="wrapper">

  @include('admin.include.header')
  
  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.include.siderbar')

  <!-- Content Wrapper. Contains page content -->
  @yield('mainarea')
  <!-- /.content-wrapper -->
	
  @include('admin.include.footer')
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
</div>
<!-- ./wrapper -->
	@include('admin.include.script') 
</body>
</html>
