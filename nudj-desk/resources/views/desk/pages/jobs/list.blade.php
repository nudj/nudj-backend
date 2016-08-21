@extends('desk.content')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}">
    @endsection

    @section('page')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Jobs</h1>
        <ol class="breadcrumb">
            <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Jobs</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">List of Jobs</h3>
            </div>

            <div class="box-body">
                <!-- Filters -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Filters</h3>
                    </div>
                    <div class="panel-body">
                        <form id="search-form" class="form-inline" role="form">
                            <div class="form-group">
                                <label for="email">Filter by&nbsp: </label>
                                <select name="operator" id="operator" class="form-control">
                                    <option value="">All</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Filters -->
                <div id="users_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-striped table-hover dt-responsive" cellspacing="0" width="100%" id="jobs-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Company</th>
                                    <th>Salary</th>
                                    <th>Bonus</th>
                                    <th>Active</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Company</th>
                                    <th>Salary</th>
                                    <th>Bonus</th>
                                    <th>Active</th>
                                    <th>Created At</th>
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
            var tbl_el = $('#jobs-table');
            var table = tbl_el.DataTable({
                processing: true,
                serverSide: true,
                ajax: 'datatables/jobs',
                columnDefs: [ {
                    "aTargets": -1,
                    "data": null,
                    "defaultContent": '<a id="show" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Show</a>'
                } ,
                    {
                        "aTargets" : [7],
                        "mRender": function ( data, type, full ) {
                            if(data){
                                var mDate = moment(data);
                                return (mDate && mDate.isValid()) ? mDate.format("YYYY-MM-DD") : "";
                            }
                            return "";
                        }
                    },
                    {
                        "aTargets" : [6],
                        "mRender": function ( data, type, full ) {
                            if(data > 0){
                                return '<span class="label label-success">Active</span>';
                            }
                            return '<span class="label bg-red">Inactive</span>';
                        }
                    }
                ],
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'location', name: 'location' },
                    { data: 'company', name: 'company' },
                    { data: 'salary', name: 'salary' },
                    { data: 'bonus', name: 'bonus' },
                    { data: 'active', name: 'active' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "order": [[ 0, "desc" ]]
            });

            $("#operator").on('change',function(){
//                var original="";
//                table.columns([6]).search(original ? original : '', true, false).draw();
//
//                if($(this).val().length > 0){
//                            original ="1";
//                            var val = $.fn.dataTable.util.escapeRegex(original);
//                            table.columns([$(this).val()]).search(val ? val : '', true, false).draw();
//                }

                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                table.columns([6]).search(val ? val : '', true, false).draw();
            });

            tbl_el.on( 'click', 'a', function () {
                var data = table.row( $(this).parents('tr') ).data();
                var ident = $(this).attr('id');
                switch (ident){
                    case "show":
                       window.location.href="jobs/"+data['id'];
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