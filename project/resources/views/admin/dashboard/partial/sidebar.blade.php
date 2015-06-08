<!-- Sidebar starts -->
<div class="sidebar">

    <div class="sidey">

        <!-- Logo -->
        <div class="logo">
            <h1><a href="#"><i class="fa fa-star br-lblue"></i> doppels <span>A Legendary App!</span></a></h1>
        </div>

        <!-- Sidebar navigation starts -->

        <!-- Responsive dropdown -->
        <div class="sidebar-dropdown"><a href="#" class="br-red"><i class="fa fa-bars"></i></a></div>

        <div class="side-nav">

            <div class="side-nav-block">
                <!-- Sidebar heading -->
                <h4>Menu</h4>
                <!-- Sidebar links -->
                <ul class="list-unstyled">
                    <li><a href="{{ URL::to('dashboard') }}" class="active"><i class="fa fa-desktop"></i> Dashboard</a></li>
                    <li><a href="{{ URL::to('subscribers') }}"><i class="fa fa-user"></i> Subscribers</a></li>
                </ul>
            </div>
        </div>
        <!-- Sidebar navigation ends -->
    </div>
</div>

<!-- Sidebar ends -->