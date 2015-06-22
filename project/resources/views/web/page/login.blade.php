@extends('web.app')

@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container">
            <img class="logo" src="{{ asset('assets/web/img/nudj_logo.png') }}"/>
        </div>
    </nav>
    <div id="name" class="container">
        <p class="lead">Hi</p>
    </div>
    <div id="paragraph" class="container">
        <p class="lead">We need to verify your mobile number before you can see the job details.</p>
    </div>
    <div id="country" class="container" style="text-align: center;">
        <select class="selectpicker">
            <option value="44">United Kingdom (+44)</option>
            <option value="45">United Kingdom (+44)</option>
            <option value="46">United Kingdom (+44)</option>
        </select>
    </div>
    <div id="phone" class="container">

    </div>
    <div id="push" class="container">
        <div id="submit" class="btnsubmit"></div>
    </div>
    <div id="copyright" class="container copy">
       <span>Copyright Nudj 2015<span>
    </div>
@endsection

