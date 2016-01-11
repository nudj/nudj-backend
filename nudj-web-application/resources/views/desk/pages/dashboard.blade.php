@extends('desk.content')

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
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
                <span class="info-box-icon bg-yellow"><i class="ion ion-android-contacts"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Users</span>
                    <span class="info-box-number">{{$users or 0}}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-cash"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jobs</span>
                    <span class="info-box-number">{{$jobs or 0}}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>

    </div>

</section>
<!-- /.content -->

@endsection