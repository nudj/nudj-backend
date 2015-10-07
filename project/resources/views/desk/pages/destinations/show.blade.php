@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Destination Info</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Destination Info</a></li>
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
                        Destination for has been updated!
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

                    <h3 class="profile-username text-center">{{ $name or null }}</h3>
                    <p class="text-muted text-center">Creation date : {{ date('Y-m-d', strtotime($created_at)) }}</p>


                    <div id="map_canvas"></div>
                    <p class="text-muted text-center"></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Rating</b> <a class="pull-right">{{$rating or 0}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Latitude</b> <a class="pull-right">{{$lat or 0}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Longitude</b> <a class="pull-right">{{$lon or null}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Top Pick</b> <a class="pull-right">{{$pick or null}}</a>
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
                        <form class="form-horizontal" method="POST" action="{{ url('/destinations') }}/{{$id}}" >
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$name or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="{{$description or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Latitude</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lat" name="lat" placeholder="Latitude" value="{{$lat or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Longitude</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lon" name="lon" placeholder="Longitude" value="{{$lon or null}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Top Pick</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="pick" name="pick" placeholder="Top Pick" min="0" max="1" value="{{$pick or 0}}">
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
                map: map,
                title: "{{ $name}}"
            });
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOeXMB-8tNtBKTjujAZxbJL5ffzK222es&callback=initMap">
    </script>
@endsection