@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Note Info</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Note Info</a></li>
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

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">

                    <h3 class="profile-username text-center">Note</h3>
                    <p class="text-muted text-center">Creation date : {{ date('Y-m-d', strtotime($created_at)) }}</p>


                    <div id="map_canvas"></div>
                    <p class="text-muted text-center"></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Likes</b> <a class="pull-right">{{$likes or 0}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Reported</b> <a class="pull-right">{{$reported or null}}</a>
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="POST" action="{{ url('/notes') }}/{{$id}}" >
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="message" name="message" placeholder="Message">{!! $message or null !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">User</label>
                                <div class="row col-sm-10">
                                <div class="col-sm-2">
                                        <label for="email" class="control-label">Id</label>
                                        <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Id" value="{{$user_id or null}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email" class="control-label">Name</label>
                                        <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Name" value="{{$uname->name or null}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Destination</label>
                                <div class="row col-sm-10">
                                    <div class="col-sm-2">
                                        <label for="email" class="control-label">Id</label>
                                        <input type="text" class="form-control" id="destination_id" name="destination_id" placeholder="Id" value="{{$destination_id or null}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email" class="control-label">Name</label>
                                        <input type="text" class="form-control" id="destination_name" name="destination_name" placeholder="Name" value="{{$dname->name or null}}">
                                    </div>
                                    @if(isset($destination_id))
                                        <div class="col-sm-2" style="margin-top:30px;">
                                            <a href="{{ url('/destinations') }}/{{$destination_id}}" id="show" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Show</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Amenity</label>
                                <div class="row col-sm-10">
                                    <div class="col-sm-2">
                                        <label for="email" class="control-label">Id</label>
                                        <input type="text" class="form-control" id="amenity_id" name="amenity_id" placeholder="Id" value="{{$amenity_id or null}}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="email" class="control-label">Name</label>
                                        <input type="text" class="form-control" id="amenity_name" name="amenity_name" placeholder="Name" value="{{$aname->name or null}}">
                                    </div>
                                    @if(isset($amenity_id))
                                        <div class="col-sm-2" style="margin-top:30px;">
                                            <label class="control-label">    </label>
                                            <a href="{{ url('/amenities') }}/{{$amenity_id}}" id="show" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Show</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
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

    <script type="text/javascript">


        function initMap() {
            var myLatLng = {lat: {{$lat}}, lng: {{$lon}}};

            var map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 4,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map
            });
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOeXMB-8tNtBKTjujAZxbJL5ffzK222es&callback=initMap">
    </script>
@endsection