@extends('admin.dashboard.layout')

@section('content')



    <div class="page-content">

        <!-- Heading -->
        <div class="single-head">
            <!-- Heading -->
            <h3 class="pull-left"><i class="fa fa-cog green"></i>Repair</h3>


            <div class="clearfix"></div>
        </div>

        <div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered ">
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Disaster Level</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Repair Elastic Index</td>
                        <td>Deletes everything from Search Engine and recreates it from the database</td>
                        <td><span class="label label-success">Safe</span></td>
                        <td>
                            <a href="{{ api_url('elastic/repair?' . http_build_query(['token' => $token ])) }}"  class="btn btn-xs btn-success action-repair"><i class="fa fa-check"></i> </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <iframe id="iframe">

            </iframe>

        </div>


    </div>


@endsection


@section('runnable')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {

            $('.action-repair').click(function(e) {

                e.preventDefault();

                var url = $(this).attr('href');
                $('#iframe').prop('src', url);
            });

        });
    </script>
@endsection
