@extends('web.app')

@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container head-container">
            <div class="head-text">
                Job Details
            </div>
        </div>
    </nav>

    <div id="name" class="container">
        <div class="col-lg-1 col-centered">
            <p class="lead newp">

            </p>

        </div>
    </div>

    <div id="status" class="container no-padding">
        <div class="in-status">
            <div id="left-cell">
                Job Status
            </div>
            <div id="right-cell">
                <img class="status-check" src="{{ asset('assets/web/img/check.png') }}"/>Active
            </div>
        </div>
    </div>

    <div id="push" class="container from-top">
        <div class="col-lg-1 col-centered">
            <div id="submit" class="btn-apply">
                <div id="btn-submit">
                    APPLY
                </div>
            </div>
        </div>
    </div>
@endsection