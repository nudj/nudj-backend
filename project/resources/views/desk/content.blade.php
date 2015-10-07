@extends('desk.layout')


@section('content')

    <div class="hold-transition skin-purple sidebar-mini">
        <div class="wrapper">

        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>TW</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Trip</b>Wire</span>
            </a>


            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        @include('desk.partials.actionbar')

                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->

        <aside class="main-sidebar">
            <section class="sidebar">
                @include('desk.partials.navigation')
            </section>
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('page')
        </div>


    </div>
    </div>

@endsection