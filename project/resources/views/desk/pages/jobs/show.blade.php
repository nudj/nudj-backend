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
                    @if(isset($photo))
                    <img class="profile-user-img img-responsive img-circle" src="{{$photo}}" alt="User profile picture">
                    @else
                       <div class="profile-user-img img-circle text-center correct-circle">
                         <i class="fa fa-user fa-5x"></i>
                       </div>
                    @endif
                    <h3 class="profile-username text-center">{{ $name or null }}</h3>
                    <p class="text-muted text-center">Creation date : {{ date('Y-m-d', strtotime($created_at)) }}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Followers</b> <a class="pull-right">{{$hasfollowers or 0}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Following</b> <a class="pull-right">{{$hasfollowing or 0}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Referral</b> <a class="pull-right">{{$referral or null}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Top Tripper</b> <a class="pull-right">{{$top or null}}</a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="POST" action="{{ url('/user') }}/{{$id}}" >
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$name or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$email or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$username or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bio" class="col-sm-2 control-label">Bio</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="bio" name="bio" placeholder="Bio">{!! $bio or null !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="referral" class="col-sm-2 control-label">Referral</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="referral" name="referral" placeholder="Referral" value="{{$referral or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="referral" class="col-sm-2 control-label">Top Tripper</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="top" name="top" placeholder="top" min="0" max="1" maxlength="1" value="{{$top or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nationality" class="col-sm-2 control-label">Nationality</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Nationality" value="{{$nationality or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Update</button>
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