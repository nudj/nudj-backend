@extends('web.app')


@section('title')
    <title>Job title</title>
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_job.css') }}" rel="stylesheet">
@endsection


@section('page')

    <nav class="navbar navbar-inverse navbar-fixed-top coloredhead">
        <div class="container head-container">
            <div class="col-xs-12 col-centered col-max head-text">
                Job Details
            </div>
        </div>
    </nav>

    <div id="name" class="container">
        <div class="col-xs-12 col-centered col-max">
            <p class="lead newp">

            </p>

        </div>
    </div>

    <div id="status" class="container-fluid no-padding">
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
        <div class="col-xs-12 col-centered col-max">
            <div id="submit" class="btn-apply">
                <div id="btn-submit">
                    APPLY
                </div>
            </div>
        </div>
    </div>
@endsection