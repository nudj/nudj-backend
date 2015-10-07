@extends('desk.content')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}">
    @endsection

    @section('page')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Users</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of Users</h3>
            </div>
            <div class="box-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filters</h3>
                    </div>
                    <div class="panel-body">
                        <form id="search-form" class="form-inline" role="form">
                            <div class="form-group">
                                <label for="email">Filter by&nbsp: </label>
                                <select name="operator" id="operator" class="form-control">
                                    <option value="" selected>All</option>
                                    <option value="4">Top tripper</option>
                                    <option value="5">Reported</option>
                                    <option value="7">Disabled</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="users_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%" id="users-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Top Tripper</th>
                                    <th>Reported</th>
                                    <th>Created At</th>
                                    <th>Disabled</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Top Tripper</th>
                                    <th>Reported</th>
                                    <th>Created At</th>
                                    <th>Disabled</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="box-footer"></div>

        </div>


    </section>


@endsection

@section('scripts')
    @parent
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
@endsection

@section('runnable')
    @parent
    <script>
        $( document ).ready(function()  {
            var tbl_el = $('#users-table');
            var table = tbl_el.DataTable({
                processing: true,
                serverSide: true,
                ajax: 'datatables/users',
                columnDefs: [ {
                    "aTargets": -1,
                    "data": null,
                    "defaultContent": '<a id="show" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Show</a>  <a id="remove" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Remove</a>'
                } ,
                    {
                        "aTargets" : [6],
                        "mRender": function ( data, type, full ) {
                            if(data){
                                var mDate = moment(data);
                                return (mDate && mDate.isValid()) ? mDate.format("YYYY-MM-DD") : "";
                            }
                            return "";
                        }
                    },
                    {
                        "aTargets" : [4],
                        "mRender": function ( data, type, full ) {
                            if(data && data >0){
                                return '<span class="label label-success">Top Tripper</span>';
                            }
                            return "";
                        }
                    },
                    {
                        "aTargets" : [5],
                        "mRender": function ( data, type, full ) {
                            if(data == 1){
                                return '<span class="label label-warning">Reported</span>';
                            }
                            return "";
                        }
                    },
                    {
                        "aTargets" : [7],
                        "mRender": function ( data, type, full ) {
                            if(data){
                                return '<span class="label label-danger">Disabled</span>';
                            }
                            return "";
                        }
                    }
                ],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'top', name: 'top' },
                    { data: 'reported', name: 'reported' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'disabled', name: 'disabled'},
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "order": [[ 0, "desc" ]]
            });

            $("#operator").on('change',function(){
                var original="";
                table.columns([4,5,7]).search(original ? original : '', true, false).draw();

                if($(this).val().length > 0){
                            original ="1";
                            var val = $.fn.dataTable.util.escapeRegex(original);
                            table.columns([$(this).val()]).search(val ? val : '', true, false).draw();
                }
            });

            tbl_el.on( 'click', 'a', function () {
                var data = table.row( $(this).parents('tr') ).data();
                var ident = $(this).attr('id');
                switch (ident){
                    case "show":
                        window.location.href="user/"+data['id'];
                        break;
                    case "update":
                        break;
                    case "remove":
                        break;
                }
            } );

        });
    </script>
@endsection