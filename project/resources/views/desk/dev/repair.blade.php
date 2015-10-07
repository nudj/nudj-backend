@extends('desk.content')

@section('page')

    <section class="content-header">
        <h1>Repairs</h1>
    </section>

    <section class="content">
        <div class="box">


            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Disaster Level</th>
                        <th>Do It!</th>
                    </tr>




                    <tr>
                        <td>Repair Elastic</td>
                        <td>Recreates the whole Elastic index from Database. May be slow for big databases</td>
                        <td><span class="label label-success">Can't hurt you</span></td>
                        <td>
                            <a href="{{url('command/repairElastic')}}" data-type="GET" class="action-repair">
                                <span class="label label-success"><i class="fa fa-check"></i></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Composer Update</td>
                        <td>Executes "composer update" on the server</td>
                        <td><span class="label label-warning">Spilled Coffee</span></td>
                        <td>
                            <a href="{{url('command/conposerUpdate')}}" data-type="GET" class="action-repair">
                                <span class="label label-success"><i class="fa fa-check"></i></span>
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>Composer Update --no-dev</td>
                        <td>Executes "composer update --no-dev" on the server</td>
                        <td><span class="label label-warning">Spilled Coffee</span></td>
                        <td>
                            <a href="{{url('command/composerUpdateNoDev')}}" data-type="GET" class="action-repair">
                                <span class="label label-success"><i class="fa fa-check"></i></span>
                            </a>
                        </td>
                    </tr>


                    <tr>
                        <td>Reset EVERYTHING!</td>
                        <td>This will start the Full Reset procedure deleting all the data in the MySQL, Elastic and all the Files on Rackspace </td>
                        <td><span class="label label-danger">Armageddon!!!</span></td>
                        <td>
                            <a href="{{url('command/fullRefresh')}}" data-type="GET" class="action-repair">
                                <span class="label label-success"><i class="fa fa-check"></i></span>
                            </a>
                        </td>
                    </tr>


                    </tbody>
                </table>
            </div>


        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Console</h3>
            </div>
            <div class="box-body no-padding">
                <div id="console"></div>
            </div>
        </div>

    </section>
@endsection


@section('runnable')
    @parent

    <script type="text/javascript">
        $(document).ready(function () {

            $('.action-repair').click(function (e) {

                e.preventDefault();
                var url = $(this).attr('href');
                var type = $(this).data('type');
                $.ajax({
                    type: type,
                    url: url,
                    contentType: "application/json",
                    success: function (data) {
                        $("#console").html(data);
                    }
                });


            });

        });
    </script>
@endsection
