@extends('web.app')

@section('title')
    <title>Login</title>
    <meta name="apple-itunes-app" content="app-id=1027993202, app-argument=https://itunes.apple.com/app/id1027993202">
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_download.css') }}" rel="stylesheet">
@endsection



@section('page')

    <nav class="navbar navbar-inverse coloredhead">
        <div class="container">
            <div class="logo">
            <p class="paragraph">To view this job, download</p>
            <p class="paragraph">our free iPhone app.</p>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="logo">
           <img class="img-resp" src="{{ asset('assets/web/img/iPhone.png') }}">
        </div>
    </div>

    <div class="container">
        <div class="logo">
            <a href="https://itunes.apple.com/app/id1027993202" target="_self" ><img class="img-resp" src="{{ asset('assets/web/img/app-store.png') }}"></a>
        </div>
    </div>


    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright Nudj 2015</p>
        </div>
    </footer>
@endsection

@section('scripts')
    @parent
@endsection