<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar" style="height: auto;">
		  
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image"><?php $data=DB::table('users')->where('id',Auth::user()->id)->first(); ?>
          <img src="@if($data->profile_image) {{ URL::asset('admin_assets/upload') }}/{{$data->profile_image}} @else {{ URL::asset('admin_assets/images/logo-big.png') }} @endif" class="rounded-circle" alt="User Image">
        </div>
        <div class="info">
        </div>
      </div>
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu tree" data-widget="tree">
		  
        <li><a href="{{ URL::asset('partner/dashboard') }}"><i class="ti-more"></i>Global Dashboard</a></li>
		
        <li class="treeview active menu-open">
          <a href="#">
            <i class="ti-dashboard"></i>
            <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ URL::asset('partner/dashboard') }}"><i class="ti-more"></i>Dashboard</a></li>
            <li><a href="{{ URL::asset('partner/student') }}"><i class="ti-more"></i>Student Register</a></li>
            <li><a href="{{ URL::asset('partner/session') }}"><i class="ti-more"></i>Session</a></li>
            <li><a href="{{ URL::asset('partner/class') }}"><i class="ti-more"></i>Class</a></li>
            <li><a href="{{ URL::asset('partner/section') }}"><i class="ti-more"></i>Section</a></li>
          </ul>
        </li>  
        
      </ul>
    </section>
  </aside>