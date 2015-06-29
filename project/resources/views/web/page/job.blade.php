@extends('web.app')


@section('title')
    <title>Job</title>
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_job.css') }}" rel="stylesheet">
@endsection


@section('page')

    <nav class="navbar navbar-inverse coloredhead">
        <img class="head-logo" src="{{ asset('assets/web/img/nudj_logo_small.png') }}"/>
        <div class="container head-container">
            <div class="col-xs-12 col-centered col-max head-text">
                Job Details
            </div>
        </div>
    </nav>

    <div id="name" class="container-fluid no-padding" style="text-align: left;">
        <div class="row-fluid no-padding" style="text-align: left;">
            <div id="job-title" class="container-fluids">
                <span class="span-title">{{$job->title}}</span>
            </div>
            <div id="job-from" class="container-fluids margins-top-small span-grey">
                Posted from: {{--<span class="span-green">{{$job->from}}</span>--}}
            </div>
            <div id="job-description" class="container-fluids margins-top">
                {{$job->description}}
            </div>
            <div id="job-tags" class="container-fluids margins-top">
{{--                <div style="display:table;border-spacing: 5px;">
                    @foreach ($job->skills as $skill)
                        <div class="job-tags">{{ $skill }}</div>
                    @endforeach
                </div>--}}
            </div>
            <div id="job-employer" class="container-fluids margins-top">
                <img class="status-check" src="{{ asset('assets/web/img/employer.png') }}"/>
                <span class="span-grey">
                    Employer:
                </span>
                <span>
                    <span class="span-green">{{$employer->name}}</span>
                </span>
            </div>
            <div id="job-location" class="container-fluids margins-top">
                <div style="float: left;">
                    <img class="status-check" src="{{ asset('assets/web/img/pin.png') }}"/>
                <span class="span-grey">
                    Location:
                </span>
                <span>
                    <span class="span-green">London{{--{{$employer->location}}--}}</span>
                </span>
                </div>
                {{--<div class="span-green-map" data-lat ="{{$job->location->lat}}" data-lon="{{$job->location->lon}}">View map</div>--}}
                <div class="span-green-map">View map</div>
            </div>
            <div id="job-salary" class="container-fluids margins-top span-grey">
                <img class="status-check" src="{{ asset('assets/web/img/salary.png') }}"/> Salary:
                   <span class="span-green">
                        &pound; {{$job->salary}}
                    </span>
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
                <div id="btn-submit" data-type="{{$type}}">
                    APPLY
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/web/js/job_script.js') }}"></script>
@endsection