
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-4 col-xs-6">
            <!-- Page title -->

        </div>


        <div class="col-md-6 hidden-sm hidden-xs">
            <!-- Head user -->
            <div class="head-user dropdown pull-right">
                <a href="#" data-toggle="dropdown" id="profile">
                    <!-- Icon -->
                    <i class="fa fa-user"></i>

                    <!-- <img src="img/user2.png" alt="" class="img-responsive img-circle"/>  -->

                    <!-- User name -->
                    Admin
                    <i class="fa fa-caret-down"></i>
                </a>
                <!-- Dropdown -->
                <ul class="dropdown-menu" aria-labelledby="profile">
                    <li><a href="#">View/Edit Profile</a></li>
                    <li><a href="{{ admin_url('auth/logout') }}">Sign Out</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>