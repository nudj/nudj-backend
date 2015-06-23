@extends('web.app')

@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container">
            <img class="logo" src="{{ asset('assets/web/img/nudj_logo.png') }}"/>
        </div>
    </nav>

    <div id="name" class="container">
        <div class="col-lg-1 col-centered">
            <p class="lead newp">Phone Number Verification</p>

        </div>
    </div>


    <div id="paragraph" class="container">
        <div class="col-lg-1 col-centered" style="max-width: 330px;">
            <p class="lead">A 4 digit verification code has been sent to +44 546546546</p>
        </div>
    </div>



    <div id="phone" class="container">
        <div class="col-lg-1 col-centered">
            <label for="mobile" class="labels">Please this code below</label>
            <input id="mobile" name="mobile" class="mobile" type="text" value="">
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
            <p class="lead newp">Resend Code</p>

        </div>
    </div>

    <div id="copyright" class="container copy">
        <span>Copyright Nudj 2015</span>
    </div>
@endsection

