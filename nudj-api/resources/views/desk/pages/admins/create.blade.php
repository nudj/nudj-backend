@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Create a New Admin</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Create a New Admin</a></li>
        <li class="active">Create</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Create a New Admin</h3>
        </div>

        <div class="box-body">
            <div class="col-sm-3">
                @if(session()->has('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
            @elseif(session()->has('status'))
                <div class="alert alert-success">
                    Profile for {{ session('status') }} has been created!
                </div>
            @endif

            <div class="col-sm-12">

                <!-- form start -->
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admins') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="" required>
                                         <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" required>
                                         <span class="input-group-addon">
                                            <i class="fa fa-unlock-alt"></i>
                                        </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <a href="{{ url('admins') }}">
                            <button type="button" class="btn btn-default btn-flat"><i class="fa fa-list"></i>  List </button>
                        </a>
                        <button type="submit" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Create</button>
                    </div>

                </form>
                <!-- form end -->
            </div>
        </div>
        </div>

    </div>


</section>


@endsection

@section('scripts')
    @parent
@endsection

@section('runnable')
    @parent
@endsection