@extends('desk.content')

@section('styles')
@parent

@endsection

@section('page')

        <!-- Content Header (Page header) -->
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
            <div class="box box-primary">
                <div class="box-body box-profile">

                    <h3 class="profile-username text-center">Job</h3>
                    <p class="text-muted text-center">Id : <span class="label label-success">{{ $id }}</span></p>
                    <p class="text-muted text-center">Creation date : <span class="label label-success">{{ date('Y-m-d', strtotime($created_at)) }}</span></p>

                    <p class="text-muted text-center"></p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Active</b>
                            @if($active > 0)
                                <span data-toggle="tooltip" title="" class="badge bg-green pull-right" data-original-title="Active">Verified</span>
                            @else
                                <span data-toggle="tooltip" title="" class="badge bg-red pull-right" data-original-title="Inactive">Inactive</span>
                            @endif
                        </li>
                    </ul>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Details</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="settings">

                        <form class="form-horizontal" method="POST" action="{{ url('/jobs') }}/{{$id}}" >

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="box-body">
                                <div class="col-md-12">
                                    <form role="form">
                                        <!-- text input -->

                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$title or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea data-autoresize rows="10" class="form-control" id="message" name="message" placeholder="Description">{!! $description or null !!}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{$location or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="{{$company or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Salary</label>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Salary" value="{{$salary or null}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Bonus</label>
                                            <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus" value="{{$bonus or null}}">
                                        </div>

                                    </form>

                                    <div class="form-group">
                                        <a href="{{ url('/jobs') }}">
                                            <button type="button" class="btn btn-default btn-flat"><i class="fa fa-list"></i>  List </button>
                                        </a>
                                        <button type="submit" class="btn btn-danger tmp-hidden" >Update</button>
                                    </div>
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
    <script>
        jQuery.each(jQuery('textarea[data-autoresize]'), function() {
            var offset = this.offsetHeight - this.clientHeight;

            var resizeTextarea = function(el) {
                jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
        });
    </script>
@endsection