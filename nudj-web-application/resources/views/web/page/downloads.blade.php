@extends('web.app')

@section('title')
    <title>Download</title>
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
        <div class="img-holder">
           <img class="img-resp-phone" src="{{ asset('assets/web/img/iPhone_line.png') }}">
        </div>
    </div>

    <div class="container">
        <div class="img-holder">
            <a href="https://geo.itunes.apple.com/gb/app/nudj-the-talent-referral-app/id1081609782?mt=8" target="_self" ><img class="img-resp-app" src="{{ asset('assets/web/img/app-store.png') }}"></a>
        </div>
    </div>


    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright Nudj 2016</p>
        </div>
    </footer>
@endsection

@section('scripts')
    @parent
@endsection