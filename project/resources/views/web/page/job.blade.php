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

    <div id="name" class="container-fluid no-padding">
        <div class="col-xs-12 col-centered col-max">
            <div id="job-title" class="container-fluid">
                {{$job->title}}
            </div>
            <div id="job-from" class="container-fluid">
                Posted from: {{$job->from}}
            </div>
            <div id="job-description">
                {{$job->description}}
            </div>
            <div id="job-tags" class="container-fluid">
                @foreach ($job->tags as $tag)
                    <div>{{ $tag }}</div>
                @endforeach
            </div>
            <div id="job-employer" class="container-fluid">
                <img class="status-check" src="{{ asset('assets/web/img/employer.png') }}"/> Employer: {{$job->employer}}
            </div>
            <div id="job-location" class="container-fluid">
                        <div><img class="status-check" src="{{ asset('assets/web/img/pin.png') }}"/> Location: {{$job->location->name}}</div>
                        <div data-lat ="{{$job->location->lat}}" data-lon="{{$job->location->lon}}">View map</div>
            </div>
            <div id="job-salary" class="container-fluid">
                <img class="status-check" src="{{ asset('assets/web/img/salary.png') }}"/> Salary: &pound; {{$job->salary}}
            </div>
        </div>
    </div>

    <div id="status" class="container-fluid no-padding">
        <div class="in-status">
            <div id="left-cell">
                <img class="status-check" src="{{ asset('assets/web/img/suitcase.png') }}"/>Job Status
            </div>
            <div id="right-cell">
                @if ($job->status === 1)
                <img class="status-check" src="{{ asset('assets/web/img/check.png') }}"/><span style="color: #00A187;">Active</span>
                @else
                    <span>Inactive</span>
                @endif
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