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
                            '<div ><textarea id="themsg" placeholder="Write your referral message" cols="30" rows="4" onfocus="runFocus(this.id);"></textarea></div>' +
                            '<div id="ref-content"><input class="refMsg" id="refname" name="refname" value="" placeholder="Name"  onfocus="runFocus(this.id);"/>'+
                            '<select id="countr" class="form-control" style="margin-top: 14px;" onchange="myFunction();">'+goCountr+'</select>'+
                            '<input style="margin-top: 14px;" class="refcoda" id="refcode" name="refcode" value="+44" placeholder=""/><input class="refMsg-phone" id="refphone" name="refphone" style="  float: left;width: 158px;  margin-top: 14px;" value="" placeholder="Phone Number" onfocus="runFocus(this.id);"/> </div>' +
                            '<div id="refs-btn"><div id="btn-ok" style="" >SEND SMS</div></div></div>';

                })
                .fail(function() {
                    console.log( "error" );
                });

        /*refer*/

        $("#refs-btn").click(function(e){
            /*e.preventDefault();*/
            var chkr = 0;

            if($("#refphone").val().length == 0){
                chkr = chkr +1;
                $("#refphone").css("border-color","red");
            }
            if($("#refname").val().length == 0){
                chkr =chkr + 1;
                $("#refname").css("border-color","red");
            }
            if($("#themsg").val().length == 0){
                chkr =chkr + 1;
                $("#themsg").css("border-color","red");
            }

            if(chkr == 0){
                var job_id = $("#job_id").val();

                var put_data = {job_id:job_id};
                $.post( base_path +"/refer", put_data,function(data) {})
                        .done(function( data ) {
                            successSpoter();
                            setTimeout(function() {
                                parent.TINY.box.hide();
                            }, 3000);
                        })
                        .fail(function(){
                            TINY.box.show({html:msgFail,width:200,height:200,fixed:false,maskid:'bluemask',maskopacity:40,close:false,closejs:function(){closeFailed()}})
                        })


            }

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
                <input type="hidden" id="job_id" name="job_id" value="{{$job->id}}" />
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

    @if($type == 1)
    <div id="status" class="container-fluid">
        <div class="col-xs-12 col-centered col-max" style="font-size: 20px; padding: 30px;">
            Referral Bonus: <span style="color: #1293BD;">&pound;{{$job->bonus}}</span>
        </div>
    </div>
    <div id="push" class="container">
    @else
       <div id="push" class="container from-top">
    @endif

        <div class="col-xs-12 col-centered col-max">
            <div id="submit" class="btn-apply">
                <div id="btn-submit" data-type="nudge">
                    APPLY
                </div>
                @if($type === 'refer')
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