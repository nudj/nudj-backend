@extends('web.app')

@section('title')
    <title>Job</title>
@endsection

@section('apple')
    <meta name="apple-itunes-app" content="app-id=1081609782, app-argument=https://{{$hostname}}/jobpreview/{{$job->id}}/00000000">
@endsection

@section('styles')
    @parent
    <link href="{{ asset('assets/web/css/theme_job.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/web/css/job-page-4e2960ca.css') }}" rel="stylesheet">
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

    <nav class="navbar navbar-inverse class-f07830e9-header">

        <div class="class-87505d1c">
            <div>
                <img class="job-page-v021f9cb6-head-logo" src="{{ asset('assets/web/img/nudj_logo_small.png') }}"/>
            </div>
            <div class="class-3bb9423b-head-logo-text">
                The Talent Referral App
            </div>
        </div>

        <div class="class-b7f4518a">
            <div>Find your dream job or help your friends find theirs.</div>
            <div>Download the app to see who's hiring.</div>
        </div>

    </nav>

    <!-- {!! $top_explanation_975fb67e !!} -->

    <div class="class-e854176f">Hey! We're using Nudj to help us hire but need some help. Do you know anyone who might be interested in this job ?</div>    

    <div class="class-715a5d51-job-card">
        <div class="title">
            {{$job->title}}
        </div>
        <div class="company">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 
            <span class="company-name">{{$employer}}</span>
        </div>
        <div class="location">
            <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> 
            <span class="location-name">{{$job->location}}</span>
        </div>
        <div class="posted">
            Posted: <span class="posted-time">Today</span>
        </div>
        <div class="salary">
            Salary: <span class="salary-inner">{{$job->salary}}</span>
        </div>
        @if($job->bonus>0)
        <div class="bonus">
            Referral bonus: <span class="bonus-inner">{{$job->bonus_currency}} {{$job->bonus}}</span>
        </div>
        @endif
        <div class="job-description">
            {{$job->description}}
        </div>
        <div class="tags">
            @foreach ($skills as $skill)
                <span class="badge-64e0cc7a">{{$skill->name}}</span>
            @endforeach
        </div>
        <hr />
        <div class="bottom-logo">
            <img src="{{ asset('assets/web/img/logo-4084e55d.png') }}" />
        </div>
    </div>

    <div class="class-076e42fe-user-interaction">
        <div class="f5e9a67c" onclick="navigate_to_applying_2f0b93a2();">
            <div style="margin: auto;">I'll Apply</div>
        </div>
        <div class="f87ac018" onclick="navigate_to_nudj_a_friend_1e72f178();">
            <div style="margin: auto;">Nudj a friend</div>
        </div>
    </div>

    <div style="clear:both;"></div>

    <div class="class-f300f3dd-bottom-link">
        <a href="http://nudj.co">What is Nudj? Learn more</a>
    </div>

<script>
    function navigate_to_nudj_a_friend_1e72f178(){
        location.href = '/register/{{$job->id}}'
    }
    function navigate_to_applying_2f0b93a2(){
        location.href = '/applying/{{$job->id}}'
    }
</script>

@endsection

@section('scripts')
    @parent
    @if($job->active)
    <script src="{{ asset('assets/web/js/job_script.js') }}"></script>
    @endif
@endsection