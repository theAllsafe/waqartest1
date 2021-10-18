 <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo -->
	  <div class="logo-mini">
		  <span class="light-logo"><img src="{{ URL::asset('admin_assets/images/School.png') }}" alt="logo"></span>
		  <span class="dark-logo"><img src="{{ URL::asset('admin_assets/images/School.png') }}" alt="logo"></span>
	  </div>
      <!-- logo-->
      <div class="logo-lg">
		  <span class="light-logo"><img src="{{ URL::asset('admin_assets/images/School.png') }}" alt="logo"></span>
	  	  <span class="dark-logo"><img src="{{ URL::asset('admin_assets/images/School.png') }}" alt="logo"></span>
	  </div>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
	  <div>
		  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<i class="ti-align-left"></i>
		  </a>
		
	  </div>
		
      <div class="navbar-custom-menu r-side">
        <ul class="nav navbar-nav">
		  <!-- User Account-->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php $data=DB::table('users')->where('id',Auth::user()->id)->first(); ?>
              <img src="@if($data->image) {{ URL::asset('admin_assets/upload') }}/{{$data->image}} @else {{ URL::asset('admin_assets/images/logo-big.png') }} @endif" class="user-image rounded-circle" alt="User Image">
            </a>
            <ul class="dropdown-menu animated flipInX">
              <!-- User image -->
              <li class="user-header bg-img" style="background-image: url({{ URL::asset('admin_assets/images/user-info.jpg') }})" data-overlay="3">
				  <div class="flexbox align-self-center">					  
				  	<img src="@if($data->image) {{ URL::asset('admin_assets/upload') }}/{{$data->image}} @else {{ URL::asset('admin_assets/images/logo-big.png') }} @endif" class="float-left rounded-circle" alt="User Image">					  
					<h4 class="user-name align-self-center">
					  <span>{{Auth::user()->name}}</span>
					  <small>{{Auth::user()->email}}</small>
					</h4>
				  </div>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
					<a class="dropdown-item" href="{{ URL::asset('admin/profile') }}"><i class="ion ion-settings"></i> My Profile</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ URL::asset('admin/logout') }}"><i class="ion-log-out"></i> Logout</a>
              </li>
            </ul>
          </li>	
			
		  
          <!-- Control Sidebar Toggle Button -->
          <!--<li>-->
          <!--  <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>-->
          <!--</li>-->
			
        </ul>
      </div>
    </nav>
  </header>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
	  
	<div class="rpanel-title"><span class="btn pull-right"><i class="ion ion-close" data-toggle="control-sidebar"></i></span> </div>  
    
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->