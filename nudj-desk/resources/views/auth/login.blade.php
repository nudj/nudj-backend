@extends('desk.layout')

@section('content')

    <div class="hold-transition login-page">

        <div class="login-box">

            <div class="login-logo bg-nudj">
                <span class="white-nudj"><b>Nudj</b></span>
            </div>
            <!-- /.login-logo -->

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="error">
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to continue</p>

                <form action="{{url('auth/login')}}" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group has-feedback">
                        <input name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="rememberme"> Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-success btn-block btn-flat bg-nudj">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="row">
                    <hr/>
                    <div class="col-xs-12 text-center login-copyright">
                        <strong>Made in London with love for desk.nudj.co.</strong>
                    </div>
                </div>
            </div>
            <!-- /.login-box-body -->
        </div>
    </div>



@endsection