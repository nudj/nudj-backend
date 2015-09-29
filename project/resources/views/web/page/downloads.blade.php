@extends('web.app')

@section('title')
    <title>Login</title>
    <meta name="apple-itunes-app" content="app-id=1027993202, app-argument=https://itunes.apple.com/app/id1027993202">
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme.css') }}" rel="stylesheet">
@endsection



@section('page')

    <nav class="navbar navbar-inverse" style="color:#ffffff;">
        <div class="container">
            <p style="color:#01a187;font-size:26px;">To view this job, download</p>
            <p style="color:#01a187;font-size:26px;">our free iPhone app.</p>
        </div>
    </nav>




    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright Nudj 2015</p>
        </div>
    </footer>
@endsection

@section('scripts')
    @parent
@endsection