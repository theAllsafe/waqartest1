<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar" style="height: auto;">
		  
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image"><?php $data=DB::table('users')->where('id',Auth::user()->id)->first(); ?>
          <img src="@if($data->image) {{ URL::asset('admin_assets/upload') }}/{{$data->image}} @else {{ URL::asset('admin_assets/images/logo-big.png') }} @endif" class="rounded-circle" alt="User Image">
        </div>
        <div class="info">
        </div>
      </div>
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu tree" data-widget="tree">
		<li><a href="{{ URL::asset('admin/dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a></li>
		   
        <li class="treeview">
          <a href="#">
            <i class="ti-view-list"></i>
			<span>School Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ URL::asset('admin/partner') }}">School List</a></li>
            <li><a href="{{ URL::asset('admin/partner/create') }}">Add School</a></li>
          </ul>
        </li>
   <!--     <li class="treeview">-->
   <!--       <a href="#">-->
   <!--         <i class="ti-view-list"></i>-->
			<!--<span>Admin Management</span>-->
   <!--         <span class="pull-right-container">-->
   <!--           <i class="fa fa-angle-right pull-right"></i>-->
   <!--         </span>-->
   <!--       </a>-->
   <!--       <ul class="treeview-menu">-->
   <!--         <li><a href="{{ URL::asset('admin/admin') }}">Admin List</a></li>-->
   <!--         <li><a href="{{ URL::asset('admin/admin/create') }}">Create Admin</a></li>-->
   <!--       </ul>-->
   <!--     </li> -->
        <li class="treeview">
          <a href="#">
            <i class="ti-dashboard"></i>
            <span>Student Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ URL::asset('partner/student') }}"><i class="ti-more"></i>Student list</a></li>
            <li><a href="{{ URL::asset('partner/student/create') }}"><i class="ti-more"></i>Student Add</a></li>
            <li><a href="{{ URL::asset('admin/category') }}"><i class="ti-more"></i>Category</a></li>
            <li><a href="{{ URL::asset('partner/session') }}"><i class="ti-more"></i>Session</a></li>
            <li><a href="{{ URL::asset('partner/class') }}"><i class="ti-more"></i>Class</a></li>
            <li><a href="{{ URL::asset('partner/section') }}"><i class="ti-more"></i>Section</a></li>
          </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="ti-view-list"></i>
			<span>App Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ URL::asset('admin/student/list') }}">Student List</a></li>
          </ul>
        </li>
        
        
      </ul>
    </section>
  </aside>