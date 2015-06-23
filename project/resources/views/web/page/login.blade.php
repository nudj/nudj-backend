@extends('web.app')

@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container">
            <img class="logo" src="{{ asset('assets/web/img/nudj_logo.png') }}"/>
        </div>
    </nav>
    @if (count($user) === 1)
        @foreach ($user as $current)
            <div id="name" class="container">
                <div class="col-lg-1 col-centered">
                    <p class="lead newp">Hi <span id="user-name" >{{ $current }}</span><img class="btn-edit" src="{{ asset('assets/web/img/edit_btn.png') }}"/></p>

                </div>
            </div>
        @endforeach
    @endif
    <div id="paragraph" class="container">
        <div class="col-lg-1 col-centered">
            <p class="lead newp">We need to verify your mobile number before you can see the <span class="bolder">job details</span>.</p>
        </div>
    </div>

    @if (isset($countries))
        <div id="country" class="container">
            <div class="col-lg-1 col-centered">
                <label for="countries" class="labels">Choose your country</label>

                <select id="countries" class="selectpicker">
                    @foreach ($countries as $country)
                        <option value="{{$country->code}}">{{$country->name}} (+ {{$country->code}} )</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif


    <div id="phone" class="container">
        <div class="col-lg-1 col-centered">
            <label for="mobile" class="labels">Enter your phone number</label>
            <input id="mobile" name="mobile" class="mobile" type="text" value="">
        </div>
    </div>


    <div id="push" class="container">
        <div class="col-lg-1 col-centered">
            <div id="submit" class="btnsubmit">
                <div id="btn-submit">
                    Submit
                </div>
            </div>
        </div>
    </div>

    <div id="copyright" class="container copy">
        <span>Copyright Nudj 2015</span>
    </div>
@endsection