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
        <div class="col-md-4">

            <!-- Image -->
            <div class="box box-success">
                <div class="box-body box-profile">
                    <p class="text-muted">Id : <span class="label label-success pull-right">{{ $job->id }}</span></p>
                    <p class="text-muted">Creation date : <span class="label label-success pull-right">{{ date('Y-m-d', strtotime($job->created_at)) }}</span></p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Status:</b>
                            @if($job->active > 0)
                                <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Active">Verified</span>
                            @else
                                <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Inactive">Inactive</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <b>Username:</b>
                            <a href="{{ url('/users') }}/{{ $user->id }}"><span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Link to User">{{ $user_name }}</span></a>
                        </li>
                        <li class="list-group-item">
                            <b>Email:</b>
                            <a href="{{ url('/users') }}/{{ $user->id }}"><span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Link to User">{{ $user_email }}</span></a>
                        </li>
                    </ul>
                    <div id="x22d1435b">
                        <input id="x643237cb" type="button" value="Change User" />
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
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
                                            <textarea data-autoresize rows="10" class="form-control" id="description" name="description" placeholder="Description">{!! $job->description or null !!}</textarea>
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
	                            <b>Status:</b>
	                            @if($job->active > 0)
	                                <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Active">Verified</span>
	                            @else
	                                <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Inactive">Inactive</span>
	                            @endif
	                        </li>
	                        <li class="list-group-item">
	                            <b>Username:</b>
	                            <a href="{{ url('/users') }}/{{ $user->id }}"><span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Link to User">{{ $user_name }}</span></a>
	                        </li>
                            <li class="list-group-item">
                                <b>Email:</b>
                                <a href="{{ url('/users') }}/{{ $user->id }}"><span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Link to User">{{ $user_email }}</span></a>
                            </li>
	                        <li class="list-group-item">
	                            <b>Referral Bonus:</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $job->bonus }} {{ $job->bonus_currency }}</span>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Number of referral requests:</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $referral_requests_count }}</span>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Number of active referrers:</b>
	                            <span data-toggle="tooltip" title="" class="badge bg-green pull-right">{{ $active_referrers_count }}</span>
	                        </li>
	                        <li class="list-group-item">
	                            <b>Number of application requests:</b>
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
        function install_choice_maker_fb9ae519(){
            JavaScriptUIElementsX35877E45.suite2.choiceBetweenSeveralOptions_DropDown({
                targetDiv: 'x9b41deee',
                announce: 'Which operation do you want to perform ?',
                options: [
                    {
                        description: 'Add a new skill',
                        fn: function(){

                            $('#x9b41deee').html('<div>White down a skill and click on [Update]</div><div id="x06dfad71"></div>')        

                            JavaScriptUIElementsX35877E45.suite2.textInputWithSubmitButton({
                                targetDiv : 'x06dfad71',
                                valueHandler : function(inputtext){
                                    var skill = inputtext.trim();
                                    $.ajax({
                                        type: "POST",
                                        url: '/deskapi/add_skill_to_job',
                                        data: {
                                            jobid: {{$job->id}},
                                            skill: skill
                                        },
                                        dataType: 'json',
                                        success: function(data){
                                            location.reload();
                                        },
                                        error: function(){
                                            alert('error: 74AB8E3C');
                                        }
                                    });
                                }
                            });                                

                        }
                    },
                    {
                        description: 'Remove a skill',
                        fn: function(){ cycle_skills_and_display_for_disactivation_b80e5f64(); }
                    }
                ],
            });            
        }
        JavaScriptUIElementsX35877E45.suite1.attachClickBehaviorToElement({
            targetDiv : 'b5388a06b',
            fn : function(){
                install_choice_maker_fb9ae519()
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
                    location.reload();
                },
                error: function(){
                    location.reload();
                }
            });
            
        }
    </script>   
    <script>
        // Edit job owner
        JavaScriptUIElementsX35877E45.suite1.attachClickBehaviorToElement({
            targetDiv : 'x643237cb',
            fn : function(){
                change_job_owner_step_2();
            }
        });
        function change_job_owner_step_2(){
            // Here we display the invite for the user identifier
            var html1 = '<div>user id of the new job owner: </div><div id="dfbbfc74"></div>';
            $('#x22d1435b').html(html1);
            JavaScriptUIElementsX35877E45.suite2.textInputWithSubmitButton({
                targetDiv: 'dfbbfc74', 
                valueHandler: function(value){
                    var identifier = value;
                    // We now need to override the owner of this job with the given identifier and reload the page
                    $.ajax({
                        type: "POST",
                        url: '/deskapi/ajax_set_job_owner/{{$job->id}}/'+identifier,
                        data: null,
                        dataType: 'json',
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                            location.reload();
                        }
                    });
                } 
            });
        }
    </script>     
@endsection

