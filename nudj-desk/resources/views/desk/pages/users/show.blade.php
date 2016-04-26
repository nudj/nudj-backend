@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>User Info</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">User Info</a></li>
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
                        Profile for has been updated!
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

            <!-- Profile Image -->
            <div class="box box-success">
                <div class="box-body box-profile">
                    @if(isset($user->image))
                        <?php $img = json_decode($user->image); ?>
                        <img class="profile-user-img img-responsive img-circle" src="{{ Config::get('models.users.imageUrl') }}{{ $user->id }}/profile/{{ $img->profile }}" alt="Profile picture">
                    @else
                       <div class="profile-user-img img-circle text-center correct-circle">
                         <i class="fa fa-user fa-5x"></i>
                       </div>
                    @endif
                    <h3 class="profile-username text-center">{{ $user->name or null }}</h3>
                    <p class="text-muted text-center">Creation date : <span class="label label-success">{{ date('Y-m-d', strtotime($user->created_at)) }}</span> </p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Verified</b>
                            <a class="pull-right">
                                @if($user->verified > 0)
                                    <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Verified">Verified</span>
                                @else
                                    <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Unverified">Unverified</span>
                                @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Completed</b>
                            <a class="pull-right">
                              @if($user->completed)
                                    <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Completed">Completed</span>
                              @else
                                    <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Uncompleted">Uncompleted</span>
                              @endif
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Jobs</b>
                            @if($jobs > 0)
                                <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Jobs">{{$jobs}}</span>
                            @else
                                <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="No Jobs">0</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Details</a></li>
                    <li><a href="#jobs" data-toggle="tab">Jobs</a></li>
                    <li><a href="#applications" data-toggle="tab">Applications</a></li>
                </ul>
                <div class="tab-content">

                    <div class="active tab-pane" id="settings">

                        <div>
                            <b>Database Identifier</b>: {{$user->id}}
                        </div>

                        {!! $userBlockedDisplay !!}

                        {!! $userSpecialAccessDisplay !!}

                        <form id="e9f0cc48b" class="form-horizontal">

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="box-body" style="border:1px dotted grey;">
                                <div class="col-md-12">

                                    <form role="form">
                                        <!-- text input -->

                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$user->name or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="{{$user->phone or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{$user->address or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="{{$user->company or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>About</label>
                                            <textarea class="form-control" id="about" name="about" placeholder="About">{{$user->about or null}}</textarea>
                                        </div>
                                    </form>
                                </div>
                                <input id="a7156db6" type="button" value="update user's details" />
                            </div>
                        </form>
                        <div id="E131DDB7" style="border:1px dotted grey; padding: 10px;margin-top: 20px;"></div>
                        <div id="c53bbae4" style="border:1px dotted grey; padding: 10px;margin-top: 20px;"></div>
                    </div>

                    <div class="tab-pane" id="jobs">
                        <div class="box-body">
                            <div class="col-md-12">
                                <ul class="list-group list-group-unbordered">
                                    @if(isset($user_job))
                                        @foreach($user_job as $job)
                                            <li class="list-group-item">
                                                <b>{{ $job->title }}</b>
                                                <a href="{{ url('/jobs') }}/{{ $job->id }}" class="pull-right">
                                                        <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Job"><i class="fa fa-external-link"></i></span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="form-group">
                                    <a href="{{ url('/users') }}">
                                        <button type="button" class="btn btn-default btn-flat"><i class="fa fa-list"></i>  List </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="applications">
                        <div class="box-body">
                            <div class="col-md-12">
                                <ul class="list-group list-group-unbordered">
                                    @if(isset($applications))
                                        @foreach($applications as $app)
                                            <li class="list-group-item">
                                                <b>Application for Job Id[ {{ $app->job_id }} ]</b>
                                                <a href="{{ url('/jobs') }}/{{ $app->job_id }}" class="pull-right">
                                                    <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Job"><i class="fa fa-external-link"></i></span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="form-group">
                                    <a href="{{ url('/users') }}">
                                        <button type="button" class="btn btn-default btn-flat"><i class="fa fa-list"></i>  List </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /.nav-tabs-custom -->
        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->


@endsection

@section('scripts')
    @parent
@endsection

@section('runnable')
    @parent
    <script>
        // error: 9920-34bd674f103f
        $(document).delegate('#a7156db6', 'click', function(e){
            var data = $('#e9f0cc48b').serialize()
            $.ajax({
                type: "POST",
                url: '/deskapi/ajax_update_user/{{$user->id}}',
                data: data,
                success: function(data){
                    location.reload();
                },
                error: function(){
                    alert('error: 9920-34bd674f103f');
                }
            }); 
        });
    </script>
    <script>

        var true_if_user_is_blocked = {{$true_if_user_is_blocked}};

        if(true_if_user_is_blocked){
            JavaScriptUIElementsX35877E45.suite2.Button({
                targetDiv : 'E131DDB7',
                fn : function(){
                    $.ajax({
                        type: "POST",
                        url: '/deskapi/admin_unblock_user/{{$user->id}}',
                        data: null,
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                            alert('error: a66867fe-32fd');
                        }
                    });
                },
                value: "Unblock User"
            });
        }else{
            JavaScriptUIElementsX35877E45.suite2.Button({
                targetDiv : 'E131DDB7',
                fn : function(){
                    $.ajax({
                        type: "POST",
                        url: '/deskapi/admin_block_user/{{$user->id}}',
                        data: null,
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                            alert('error: 2d11e904-d2d1');
                        }
                    });
                },
                value: "Block User"
            });            
        }

        var true_if_user_is_special_access_1 = {{$true_if_user_is_special_access_1}};

        if(true_if_user_is_special_access_1){
            JavaScriptUIElementsX35877E45.suite2.Button({
                targetDiv : 'c53bbae4',
                fn : function(){
                    $.ajax({
                        type: "POST",
                        url: '/deskapi/admin_disable_special_access/{{$user->id}}',
                        data: null,
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                            alert('error: a036d5d6-a98e');
                        }
                    });
                },
                value: "Disable Special Access"
            });
        }else{
            JavaScriptUIElementsX35877E45.suite2.Button({
                targetDiv : 'c53bbae4',
                fn : function(){
                    $.ajax({
                        type: "POST",
                        url: '/deskapi/admin_enable_special_access/{{$user->id}}',
                        data: null,
                        success: function(data){
                            location.reload();
                        },
                        error: function(){
                            alert('error: 39d325c7-ac17');
                        }
                    });
                },
                value: "Enable Special Access"
            });            
        }

    </script>
@endsection