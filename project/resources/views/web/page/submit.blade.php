@extends('web.app')

@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container">
            <img class="logo" src="{{ asset('assets/web/img/nudj_logo.png') }}"/>
        </div>
    </nav>

    <div id="name" class="container">
        <div class="col-lg-1 col-centered">
            <p class="lead newp boldest">Phone Number Verification</p>

        </div>
    </div>


    <div id="paragraph" class="container">
        <div class="col-lg-1 col-centered" style="max-width: 330px;">
            @if (count($user) === 1)
                @foreach ($user as $current)
                    <p class="lead">A 4 digit verification code has been sent to<span class="tel-span">{{$current}}</span></p>
                @endforeach
            @endif
        </div>
    </div>



    <div id="phone" class="container">
        <div class="col-lg-1 col-centered">
            <label for="mobile" class="labels">Please this code below</label>
            <div id="mobile-holder">
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-one" name="mobile-one" class="mobile" type="password" value="">
                </div>
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-two" name="mobile-two" class="mobile" type="password" value="">
                </div>
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-three" name="mobile-three" class="mobile" type="password" value="">
                </div>
                <div class="mobile-box mobile-border-left">
                    <input id="mobile-four" name="mobile-four" class="mobile" type="password" value="">
                </div>
            </div>
        </div>
    </div>


    <div id="push" class="container">
        <div class="col-lg-1 col-centered">
            <div id="submit" class="btnsubmit">
                <div id="btn-submit">
                    Confirm
                </div>
            </div>
        </div>
    </div>

    <div id="name" class="container">
        <div class="col-lg-1 col-centered">
            <p class="lead newp green boldest">Resend Code</p>

        </div>
    </div>

    <div id="copyright" class="container copy">
        <span>Copyright Nudj 2015</span>
    </div>
@endsection