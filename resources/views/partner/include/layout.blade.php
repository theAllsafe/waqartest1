<!DOCTYPE html>
<html lang="en">
  @include('partner.include.head')

<body class="skin-info sidebar-mini light-sidebar">
<div class="wrapper">

  @include('partner.include.header')
  
  <!-- Left side column. contains the logo and sidebar -->
  @include('partner.include.siderbar')

  <!-- Content Wrapper. Contains page content -->
  @yield('mainarea')
  <!-- /.content-wrapper -->
	
  @include('partner.include.footer')
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
</div>
<!-- ./wrapper -->
	@include('partner.include.script') 
</body>
</html>
