@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Admin Info</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Admin Info</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Admin</h3>
        </div>
        <div class="box-body">
            <div class=" col-sm-4">
                    <div class="row">
                        @if (session()->has('status'))
                            <div class="alert alert-success">
                                Profile for {{ session('status') }} has been updated!
                            </div>
                        @elseif(session()->has('errors'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                <!-- form start -->
                <form class="form-horizontal" role="form" action="{{url('admin')}}/{{$id}}" method="post">

                    {!! csrf_field() !!}

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$name}}">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$email}}" >
                                         <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="" >
                                         <span class="input-group-addon">
                                            <i class="fa fa-lock fa-lg"></i>
                                        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="role" name="role" placeholder="Role" value="{{$roles}}" disabled>
                                         <span class="input-group-addon">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="created-at" name="created-at" placeholder="Created at" value="{{ date('Y-m-d', strtotime($created_at)) }}"  disabled>
                                         <span class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                        </div>
                    </div>


                    <div class="form-group">
                          <a href="{{ url('admin') }}">
                              <button type="button" class="btn btn-default btn-flat"><i class="fa fa-list"></i>  List </button>
                          </a>
                          <button type="submit" class="btn btn-flat btn-danger"><i class="fa fa-pencil-square-o"></i> Update</button>

                    </div>

                </form>
                <!-- form end -->
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