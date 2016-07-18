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

        </div>
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#job_details" data-toggle="tab">Details</a></li>
                </ul>
                <div class="tab-content">

                    <!-- Details -->
                    <div class="active tab-pane" id="job_details">
                        <form id="e137df7e5" class="form-horizontal">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="box-body">
                                <div class="col-md-12">
                                    <form role="form">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea data-autoresize rows="10" class="form-control" id="description" name="description" placeholder="Description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>Company</label>
                                            <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>Salary</label>
                                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Salary" value="">
                                        </div>
                                        <div class="form-group">
                                            <label>Bonus</label>
                                            <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus" value="">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <input id="e627a410" type="button" value="Create" />
                        </form>
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
        $(document).delegate('#e627a410', 'click', function(e){
            var data = $('#e137df7e5').serialize()
            $.ajax({
                type: "POST",
                url: '/deskapi/ajax_create_job',
                data: data,
                dataType: "json",
                success: function(data){
                    var jobid = data['jobid']
                    location.href = '/jobs/'+jobid;
                },
                error: function(){
                    alert('error: 85de-2e91e845ddf9');
                }
            }); 
        });
    </script>
@endsection

