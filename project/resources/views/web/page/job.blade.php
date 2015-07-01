@extends('web.app')


@section('title')
    <title>Job</title>
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_job.css') }}" rel="stylesheet">
@endsection

@section('scriptses')
    @parent
    <script>

        $("#countr").on("change",function(){
            //var origVal = $(this).val().trim().split("-");
            //var newCode = '+' + origVal[1];
            //$("input [name=refcode]").val(newCode);
            console.log("TTTTTTTTT");
        });

        $.get( "/countries", function() {})
                .done(function(data) {
                    isVerifyet = JSON.stringify(data);
                    var obj_verifyet = eval('('+isVerifyet+')');

                    $.each( obj_verifyet, function( key, value ) {
                        if(value.name == 'United Kingdom')
                            goCountr += '<option value="'+value.name+'-'+value.code+'" selected>'+value.name+' (+'+value.code+') </option>';
                        else
                            goCountr += '<option value="'+value.name+'-'+value.code+'">'+value.name+' (+'+value.code+') </option>';
                    });

                    msgRefer =
                            '<div id="inn">'+
                            '<div id="refera-content">Refer Someone</div>' +
                            '<div ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="4"></textarea></div>' +
                            '<div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name" />'+
                            '<select id="countr" class="form-control" style="margin-top: 14px;">'+goCountr+'</select>'+
                            '<input style="  margin-top: 14px;" class="refcoda" id="refcode" name="refcode" value="+44" placeholder=""/><input class="refMsg-phone" id="refphone" name="refphone" style="  float: left;width: 158px;  margin-top: 14px;" value="" placeholder="Phone Number"/> </div>' +
                            '<div id="refs-btn" onclick="down_modal();"><div id="btn-ok" style="" >SEND SMS</div></div></div>';

                })
                .fail(function() {
                    console.log( "error" );
                });
    </script>
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
                    <img class="status-check" src="{{ asset('assets/web/img/check.png') }}"/><span style="color: #00A187;">Active</span>
            </div>
        </div>
    </div>

    <div id="push" class="container from-top">
        <div class="col-xs-12 col-centered col-max">
            <div id="submit" class="btn-apply">
                <div id="btn-submit" data-type="2">
                    APPLY
                </div>
                @if($type === 1)
                    &nbsp;&nbsp;<div id="btn-refer" data-type="{{$type}}">
                        REFER
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/web/js/job_script.js') }}"></script>
@endsection