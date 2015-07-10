@extends('web.app')

@section('title')
    <title>Login</title>
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

    <form id="login" method="post" action="{{web_url('validate')}}" >

        <div id="name" class="container">
            <div class="col-xs-12 col-centered col-max">
                <p class="lead newp">Hi, <input id="user-name" name="user-name" value="{{ $user->alias }}" />
                </p>
                <input type="hidden" name="job_id" id="job_id" value="{{$job->id}}" />
                <input id="type" name="type" value="{{$type}}" type="hidden"/>
            </div>
        </div>

        <div id="paragraph" class="container">
            <div class="col-xs-12 col-centered col-max pad-5">
                <p class="lead newp">We need to verify your mobile number before you can see the <span class="bolder">job details</span>.
                </p>
            </div>
        </div>


        <div id="country" class="container">
            <div class="col-xs-12 col-centered col-max padless" ><div class="labels">Choose your country</div></div>
            <div class="col-xs-12 col-centered col-max">
                <select id="countries" class="selectpicker" data-live-search="true">
                    @foreach ($countries as $country)
                        <option value="{{$country->name}}-{{$country->code}}-{{$country->iso2}}">{{$country->name}} (+ {{$country->code}} )</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div id="phone" class="container">
            <div class="col-xs-12 col-centered col-max padless" ><div class="labels">Enter your phone number</div></div>
            <div class="col-xs-12 col-centered col-max" style=" max-width: 350px;">
                <div id="mobile-holder">
                    <input id="code" name="code" class="code mobile-borderless-right" type="text" readonly value="+44" maxlength="5">
                    <input id="country_code" name="country_code" type="hidden" value="" maxlength="5">
                    <input id="mobile" name="mobile" class="mobile input-text-centered" type="tel" value="" placeholder="Your phone number">
                    <input id="phone" name="phone" value="" type="hidden">
                    <input id="verification" name="verification" value="{{ $type }}" type="hidden">
                </div>
            </div>
        </div>

    </form>

    <div id="push" class="container">
        <div class="col-xs-12 col-centered col-max">
            <div id="submit" class="btnsubmit">
                <div id="btn-submit">
                    Submit
                </div>
            </div>
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
    <script src="{{ asset('assets/web/js/login_script.js') }}"></script>
@endsection