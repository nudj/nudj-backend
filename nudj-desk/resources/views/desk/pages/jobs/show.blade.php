@extends('desk.content')

@section('styles')
@parent
@endsection

@section('page')

<section class="content-header">
    <h1>Job Info</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Job Info</a></li>
        <li class="active">Show</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="span-12">
            <div class="col-sm-12">
                @if (session()->has('status'))
                    <div class="alert alert-success">
                        Note for has been updated!
                    </div>
                @elseif(session()->has('errors'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-3">

            <!-- Image -->
            <div class="box box-success">
                <div class="box-body box-profile">
                    <h3 class="profile-username text-center">Job</h3>
                    <div class="container-fluid">
                        <div class="row row-centered">
                            <div class="col-xs-4 col-centered">
                                <span class="info-box-icon bg-green">
                                   <i class="ion ion-ios-briefcase"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted text-center"></p>
                    <p class="text-muted text-center">Id : <span class="label label-success">{{ $job->id }}</span></p>
                    <p class="text-muted text-center">Creation date : <span class="label label-success">{{ date('Y-m-d', strtotime($job->created_at)) }}</span></p>

                    <p class="text-muted text-center"></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Active</b>
                            @if($job->active > 0)
                                <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Active">Verified</span>
                            @else
                                <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Inactive">Inactive</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <b>User</b>
                            <a href="{{ url('/users') }}/{{ $user->id }}"><span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Link to User">{{ $user_reference }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#job_details" data-toggle="tab">Details</a></li>
                    <li><a href="#job_network" data-toggle="tab">Network</a></li>
                </ul>
                <div class="tab-content">

                    <!-- Details -->
                    <div class="active tab-pane" id="job_details">
                        <form id="e328f35e" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="box-body">
                                <div class="col-md-12">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$job->title or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea data-autoresize rows="10" class="form-control" id="description" name="Description" placeholder="Description">{!! $job->description or null !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{$job->location or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="{{$job->company or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Salary</label>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Salary" value="{{$job->salary or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Bonus</label>
                                            <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus" value="{{$job->bonus or null}}">
                                        </div>
                                    </form>
                                </div>
                                <input id="bc734f6e" type="button" value="update job details" />
                                <hr />
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Skills</label>
                                        <input type="text" class="form-control" id="bonus" name="skills" placeholder="skills" value="{{$skills}}">
                                    </div>
                                </div>
                                <div id="x6E503345"><!-- Envelop for skills edition -->
                                    <input id="b5388a06b" type="button" value="edit skills" />
                                    <br />
                                    <div id="x9b41deee"></div>
                                </div>
                                
                            </div>
                        </form>
                    </div>

                    <!-- Network -->
                    <div class="tab-pane" id="job_network">

	                    <ul class="list-group list-group-unbordered">
	                        <li class="list-group-item">
	                            <b>Active</b>
	                            @if($job->active > 0)
	                                <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Active">Verified</span>
	                            @else
	                                <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Inactive">Inactive</span>
	                            @endif
	                        </li>
	                        <li class="list-group-item">
	                            <b>User</b>
	                            <a href="{{ url('/users') }}/{{ $user->id }}"><span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Link to User">{{ $user_reference }}</span></a>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Referral Bonus</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $job->bonus }} {{ $job->bonus_currency }}</span>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Number of referral requests</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $referral_requests_count }}</span>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Number of active referrers</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $active_referrers_count }}</span>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Number of application requests</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $applications_requests_count }}</span>
	                        </li>
	                    </ul>

                        <hr />

                        <ul>
                            <li>
                                <b>Referrals</b>
                                <ul>
                                    {!! $html1 !!}
                                </ul>
                            </li>
                            <li>
                                <b>Nudges</b>
                                <ul>
                                    {!! $html2 !!}                                    
                                </ul>
                            </li>
                            <li>
                                <b>Applications</b>
                                <ul>
                                    {!! $html3 !!}                                     
                                </ul>
                            </li>
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    @parent
@endsection

@section('runnable')
    @parent
    <script>
        jQuery.each(jQuery('textarea[data-autoresize]'), function() {
            var offset = this.offsetHeight - this.clientHeight;
            var resizeTextarea = function(el) {
                jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
        });
    </script>
    <script>
        // error: 85de-2e91e845ddf9
        $(document).delegate('#bc734f6e', 'click', function(e){
            var data = $('#e328f35e').serialize()
            $.ajax({
                type: "POST",
                url: '/deskapi/ajax_update_job/{{$job->id}}',
                data: data,
                success: function(data){
                    location.reload();
                },
                error: function(){
                    alert('error: 85de-2e91e845ddf9');
                }
            }); 
        });
    </script>
    <script>
        JavaScriptUIElementsX35877E45.suite1.attachClickBehaviorToElement({
            targetDiv : 'b5388a06b',
            fn : function(){

                JavaScriptUIElementsX35877E45.suite2.choiceBetweenSeveralOptions_DropDown({
                    targetDiv: 'x9b41deee',
                    announce: 'Which operation do you want to perform ?',
                    options: [
                        {
                            description: 'Add a new skill',
                            fn: function(){}
                        },
                        {
                            description: 'Remove a skill',
                            fn: function(){ cycle_skills_and_display_for_disactivation_b80e5f64(); }
                        }
                    ],
                });

            }
        });
        function cycle_skills_and_display_for_disactivation_b80e5f64(){
            $.ajax({
                type: "GET",
                url: '/deskapi/job_skills_DataTypeB7B00162/{{$job->id}}',
                data: null,
                dataType: 'json',
                success: function(data){

                    /*
                        Item = {
                            'skill_identifier'  : Integer
                            'skill_description' : String
                        }
                        [Item]
                    */

                    var options = $.map(data,function(item){
                        return {
                           description: item.skill_description,
                           fn: function(){
                                disactivate_job_skill({{$job->id}},item.skill_identifier);
                            }      
                        };
                    });
                    JavaScriptUIElementsX35877E45.suite2.choiceBetweenSeveralOptions_OneButtonPerLine({
                        targetDiv: 'x9b41deee',
                        announce: 'Click on a skill to remove it',
                        options: options
                    });

                },
                error: function(){
                    alert('error: 754a0e70-f1a8');
                }
            });
        }
        function disactivate_job_skill(jobid,skillid){
            $.ajax({
                type: "DELETE",
                url: '/deskapi/remove_skill_from_job/'+jobid+'/'+skillid,
                data: null,
                dataType: 'json',
                success: function(data){
                    cycle_skills_and_display_for_disactivation_b80e5f64();
                },
                error: function(){
                    alert('error: 14fef1eb-f1a8');
                }
            });
            
        }
    </script>    
@endsection

