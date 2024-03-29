@extends('web.app')


@section('title')
    <title>Job</title>
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_job.css') }}" rel="stylesheet">
@endsection

@section('modal')
    @if($job->active)
    <div id="nudjModal" class="modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header header-new">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titleModal" class="modal-title"></h4>
                </div>
                <div id="bodyModal" class="modal-body modal-body-new">
                    <div id="inn">
                        <div class="holdMsg" ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="4" onfocus="runFocus(this.id);"></textarea></div>
                        <div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name"  onfocus="runFocus(this.id);"/>
                            <select id="countr" class="form-control" style="margin-top: 14px;" onchange="myFunction();">
                                @foreach ($countries as $country)
                                    <option value="{{$country->name}}-{{$country->code}}-{{$country->iso2}}">{{$country->name}} (+ {{$country->code}} )</option>
                                @endforeach
                            </select>
                            <input style="margin-top: 14px;" class="refcoda" id="refcode" name="refcode" value="+44" placeholder="" readonly/>
                            <input class="refMsg-phone" id="refphone" name="refphone" style="  float: left;width: 158px;  margin-top: 14px;" value="" placeholder="Phone Number" onfocus="runFocus(this.id);"/> </div>
                        <div id="refs-btn"><div id="btn-ok" onclick="spoter();" >SEND SMS</div></div></div>
                </div>
                <div id="footerModal" class="modal-footer">
                    <button type="button" class="btn btn-default btn-new btn-flash" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                <input type="hidden" id="refer" name="refer" value="{{$type}}" />
                <input type="hidden" id="job_id" name="job_id" value="{{$job->id}}" />
                <input type="hidden" id="hash" name="hash" value="{{$hash}}" />
            </div>
            <div id="job-from" class="container-fluids margins-top-small span-grey">
                Posted from: {{$employer}}
            </div>
            <div id="job-description" class="container-fluids margins-top">

            </div>
            <div id="job-tags" class="container-fluids margins-top">
                {{$job->description}}
            </div>
            <div id="job-employer" class="container-fluids margins-top">
            </div>
            <img class="status-check" src="{{ asset('assets/web/img/employer.png') }}"/>
                <span class="span-grey">
                    Employer:
                </span>
                <span>
                    <span class="span-green">{{$employer}}</span>
                </span>
        </div>
        <div id="job-location" class="container-fluids margins-top">
            <div style="float: left;">
                <img class="status-check" src="{{ asset('assets/web/img/pin.png') }}"/>
                <span class="span-grey">
                    Location:
                </span>
                <span>
                    <span class="span-green">London</span>
                </span>
            </div>
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
                @if($job->active)
                    <img class="status-check" src="{{ asset('assets/web/img/check.png') }}"/><span style="color: #00A187;">Active</span>
                @else
                    <span style="color: #60697D;">Inactive</span>
                @endif
            </div>
        </div>
    </div>
    @if($job->active)
    @if($type === 'refer')
        <div id="status" class="container-fluid">
            <div class="col-xs-12 col-centered col-max" style="font-size: 20px; padding: 30px;">
                Referral Bonus: <span style="color: #1293BD;">&pound;{{$job->bonus}}</span>
            </div>
        </div>
            @else
                <div id="push" class="container from-top">
                    @endif
                    <div class="col-xs-12 col-centered col-max best-alg">
                        <div id="submit-area" class="div-apply">
                            <div id="btn-apply" data-type="{{$type}}" onclick="resApply();">
                                APPLY
                            </div>
                        </div>
                        @if($type === 'refer')
                            <div id="btn-refer" data-type="{{$type}}" onclick="refResult();">
                                REFER
                            </div>
                        @endif
                    </div>
                </div>
    @endif
                @endsection

            @section('scripts')
                @parent
                @if($job->active)
                <script src="{{ asset('assets/web/js/job_script.js') }}"></script>
                @endif
@endsection