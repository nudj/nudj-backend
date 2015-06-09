@extends('admin.app')


@section('page')
<div class="outer-page">

        @if (count($errors) > 0)
            <div id="error" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Error</h4>
                        </div>
                        <div class="modal-body">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    <!-- Login page -->
    <div class="login-page">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="#login" data-toggle="tab" class="br-lblue"><i class="fa fa-sign-in"></i> Sign In</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane fade active in" id="login">

                <!-- Login form -->

                <form role="form" method="POST" action="{{ admin_url('auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me Next Time
                        </label>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm">Submit</button>
                    <button type="reset" class="btn btn-default btn-sm">Reset</button>
                </form>

            </div>

        </div>

    </div>

</div>
@endsection


@section('runnable')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            $('#error').modal('show');
        });
    </script>
@endsection