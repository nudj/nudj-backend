@extends('web.app')



@section('title')
    <title>Submit</title>
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_submit.css') }}" rel="stylesheet">
@endsection

@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container">
            <img class="logo" src="{{ asset('assets/web/img/nudj_logo.png') }}"/>
        </div>
    </nav>

    <div id="name" class="container">
        <div class="col-xs-12 col-centered col-max">
            <p class="lead newp boldest">Phone Number Verification</p>
        </div>
    </div>


    <div id="paragraph" class="container">
        <div class="col-xs-12 col-centered col-max">
                    <p class="lead">A 4 digit verification code has been sent to<span class="tel-span">{{$user->phone}}</span></p>
        </div>
    </div>



    <div id="phone" class="container">
        <div class="col-xs-12 col-centered col-max" >Please this code below</div>
        <div class="col-xs-12 col-centered col-max">
            <div id="mobile-holder">
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-one" name="mobile-one" class="mobile" type="password" value="" maxlength="1">
                </div>
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-two" name="mobile-two" class="mobile" type="password" value="" maxlength="1">
                </div>
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-three" name="mobile-three" class="mobile" type="password" value="" maxlength="1">
                </div>
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-four" name="mobile-four" class="mobile" type="password" value="" maxlength="1">
                </div>
            </div>
        </div>
    </div>


    <div id="push" class="container">
        <div class="col-xs-12 col-centered col-max">
            <div id="submit" class="btnsubmit">
                <div id="btn-submit">
                    Confirm
                </div>
            </div>
        </div>
    </div>

    <div id="resend" class="container">
        <div class="col-xs-12 col-centered col-max">
            <p class="lead newp green boldest">Resend Code</p>

        </div>
    </div>

    <div id="copyright" class="container copy">
        <span>Copyright Nudj 2015</span>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/web/js/submit_script.js') }}"></script>
@endsection