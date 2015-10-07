<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>

    <li><a href="{{ url('dashboard') }}"><span>Dashboard</span></a></li>
    <li class="treeview">
        <a href="#"><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('user') }}">List All</a></li>
            <li><a href="{{ url('user/create') }}">Create New</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Amenities</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('amenities') }}">List All</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Destinations</span> <i class="fa fa-angle-left pull-right"></i></a>
         <ul class="treeview-menu">
            <li><a href="{{ url('destinations') }}">List All</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Notes</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('notes') }}">List All</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Questions</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('questions') }}">List All</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Reviews</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('reviews') }}">List All</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Reports</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('reports') }}">List All</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Offers</span> <i class="fa fa-angle-left pull-right"></i></a>
         <ul class="treeview-menu">
            <li><a href="#">List All</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><span>Perks</span> <i class="fa fa-angle-left pull-right"></i></a>
         <ul class="treeview-menu">
            <li><a href="#">List All</a></li>
            <li><a href="#">Create New</a></li>
        </ul>
    </li>

    <li class="header">DEVELOPERS ONLY</li>
    <li class="treeview">
        <a href="#"><span>Admins</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{ url('admin') }}">List Admins</a></li>
            <li><a href="{{ url('admin/create') }}">Create a New Admin</a></li>
        </ul>
    </li>
    <li><a href="{{ url('logs') }}"><span>Logs</span></a></li>
    <li><a href="{{ url('repair') }}"><span>Repair</span></a></li>


    <li class="header">USER</li>
    <li><a href="{{ url('auth/logout') }}"><span>Log Out</span></a></li>

</ul>