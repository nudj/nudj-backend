<ul class="sidebar-menu">
    <!-- <li class="header">MAIN NAVIGATION</li> -->
    <li><a href="{{ url('dashboard') }}"><span>Dashboard</span></a></li>
    <li><a href="{{ url('users') }}">Users</a></li>
    <li>
        <a href="#"><span>Jobs</span></a>
        <ul class="">
            <li><a href="{{ url('jobs') }}">Listing</a></li>
            <li><a href="{{ url('jobs/create') }}">Create New Job</a></li>
        </ul>
    </li>
    <li><a href="{{ url('staticcontents') }}">Static Contents</a></li>
    <li>
        <a href="#"><span>Admins</span></a>
        <ul class="">
            <li><a href="{{ url('admins') }}">View</a></li>
            <li><a href="{{ url('admins/create') }}">Create</a></li>
        </ul>
    </li>
    <li><a href="{{ url('auth/logout') }}"><span>Log Out</span></a></li>
</ul>