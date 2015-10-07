@extends('desk.content')

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>it all starts here</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box-body">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Users</span>
                    <span class="info-box-number">{{$users or 0}}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-earth"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Destinations</span>
                    <span class="info-box-number">{{$destinations or 0}}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua-gradient"><i class="ion ion-android-compass"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Amenities</span>
                    <span class="info-box-number">{{$amenities or 0}}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

    </div>

</section>
<!-- /.content -->

@endsection