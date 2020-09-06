<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon fa fa-user"></i> <span>Members</span></a></li>
@can('Read All')
<li class='nav-item'><a class='nav-link' href='reports'><i class='nav-icon fa fa-file-excel-o'></i> Reports</a></li>
@endcan
<!-- Users, Roles, Permissions -->
@role('admin')
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon fa fa-group"></i>Admin</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon fa fa-group"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon fa fa-key"></i> <span>Permissions</span></a></li>
	</ul>
</li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('course') }}'><i class='nav-icon fa fa-graduation-cap'></i> Courses</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('region') }}'><i class='nav-icon fa fa-location-arrow'></i>Regions</a></li>
@endrole