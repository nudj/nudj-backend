@extends('web.app')

@section('title')
    <title>Privacy Policy</title>
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme.css') }}" rel="stylesheet">
@endsection


@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container">
            <img class="logo" src="{{ asset('assets/web/img/nudj_logo.png') }}"/>
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
    <script src="{{ asset('assets/web/js/login_script.js') }}"></script>
@endsection