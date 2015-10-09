@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>User Info</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Info</a></li>
        <li class="active">Show</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="span-12">
            <div class="col-sm-12">
                @if (session()->has('status'))
                        <div class="alert alert-success">
                            Profile for has been updated!
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
            </div>
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    @if(isset($image))
                        <?php $img = json_decode($image); ?>
                    <img class="profile-user-img img-responsive img-circle" src="{{ Config::get('models.users.imageUrl') }}{{ $id }}/profile/{{ $img->profile }}" alt="Profile picture">
                    @else
                       <div class="profile-user-img img-circle text-center correct-circle">
                         <i class="fa fa-user fa-5x"></i>
                       </div>
                    @endif
                    <h3 class="profile-username text-center">{{ $name or null }}</h3>
                    <p class="text-muted text-center">Creation date : <span class="label label-success">{{ date('Y-m-d', strtotime($created_at)) }}</span> </p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Verified</b>
                            <a class="pull-right">
                                @if($verified > 0)
                                    <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Verified">Verified</span>
                                @else
                                    <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Unverified">Unverified</span>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Completed</b>
                            <a class="pull-right">
                              @if($completed)
                                    <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Completed">Completed</span>
                              @else
                                    <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Uncompleted">Uncompleted</span>
                              @endif
                            </a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Details</a></li>
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="settings">

                        <form class="form-horizontal" method="POST" action="{{ url('/user') }}/{{$id}}" >

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="box-body">
                                <div class="col-md-12">
                                    <form role="form">
                                        <!-- text input -->

                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$name or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$email or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$phone or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{$address or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="{{$company or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>About</label>
                                            <textarea class="form-control" id="about" name="about" placeholder="About">{{$about or null}}</textarea>
                                        </div>

                                    </form>

                                    <div class="form-group">
                                        <a href="{{ url('/users') }}">
                                            <button type="button" class="btn btn-default btn-flat"><i class="fa fa-list"></i>  List </button>
                                        </a>
                                        <button type="submit" class="btn btn-danger tmp-hidden" >Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div><!-- /.tab-pane -->


                </div><!-- /.tab-content -->
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->


@endsection

@section('scripts')
    @parent
@endsection

@section('runnable')
    @parent
@endsection