@extends('admin.dashboard.layout')

@section('content')



    <div class="page-content">

        <!-- Heading -->
        <div class="single-head">
            <!-- Heading -->
            <h3 class="pull-left"><i class="fa fa-list green"></i>Logs</h3>


            <div class="clearfix"></div>
        </div>

        <div>

            <div class="table-responsive">
                <table id="log" class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="10%">ID</th>
                        <th width="10%">Type</th>
                        <th>Endpoint</th>
                        <th>Token</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>


        </div>


    </div>


@endsection


@section('runnable')
    @parent

    <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
    <script src="{{ asset('assets/thirdparty/moment/moment.min.js') }}"></script>

    <script id="tpl-line" type="text/html">
        <tr>
            <td><%= id %></td>
            <td><%= moment(id).format('MM dd h:mm') %></td>
            <td><%= type %></td>
            <td><%= endpoint %></td>
            <td><%= token ?></td>
        </tr>
    </script>

    <script type="text/javascript">

        var template;

        $(document).ready(function () {
            template = _.template($('#tpl-line').html());

            readLogFile();

        });

        function readLogFile() {
            $.get('{{admin_url('logs/line')}}', {'type': 'requests', 'lines': 20}, function (data) {
                _.each(data, function (line) {
                    if(line)
                        $('#log tbody').append(template(line));
                })
            });
        }


    </script>

@endsection
