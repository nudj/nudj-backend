<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>

    <li><a href="{{ url('dashboard') }}"><span>Dashboard</span></a></li>
    <li class="treeview">
        <a href="#"><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('users') }}">List All</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Jobs</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('jobs') }}">List All</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>

    <li class="header">DEVELOPERS ONLY</li>
    <li class="treeview">
        <a href="#"><span>Admins</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('admins') }}">List Admins</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>
    <li><a href="{{ url('logs') }}"><span>Logs</span></a></li>
    <li><a href="{{ url('repair') }}"><span>Repair</span></a></li>


    <li class="header">USER</li>
    <li><a href="{{ url('auth/logout') }}"><span>Log Out</span></a></li>

</ul>