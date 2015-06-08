@extends('dashboard.layout')

@section('content')




    <div class="container">

        <div class="page-content page-statement">

            <div class="single-head">
                <!-- Heading -->
                <h3 class="pull-left">Subscribers</h3>


                    <div class="form-group pull-right">
                        <a href="{{URL::to('subscribers/export')}}"  class="btn btn-info">
                            <i class="fa fa-download"></i>
                            <span>Download CSV</span>
                        </a>
                    </div>


                <div class="clearfix"></div>
            </div>

            <!-- Table Page -->
            <div class="page-tables">

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered ">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>IP</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->id }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->date }}</td>
                                <td>{{ $subscriber->ip }}</td>
                                <td>
                                    <a href="#" data-status="{{ $subscriber->status }}" data-id="{{ $subscriber->id }}">
                                        @if(!$subscriber->status || $subscriber->status == 'new')
                                            <span class="action-status label label-danger">new</span>
                                        @else
                                            <span class="action-status label label-success">{{ $subscriber->status }}</span>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?= $subscribers->render() ?>

                <div class="clearfix"></div>


            </div>
        </div>

    </div>


@endsection

@section('runnable')
    @parent
    <script type="text/javascript">


        $('.action-status').on("click", function () {

            var link = $(this).parent();
            var id = link.data('id');
            var status = link.data('status');

            $.post("{{URL::to('action/status/toggle')}}", {
                id: id,
                status: status,
                _token: '{{ csrf_token() }}'
            }, function (data) {

                var response = jQuery.parseJSON(data);
                if (response.success) {
                    link.data('status', response.status);
                    link.find('.label').html(response.status);

                    if (response.status == 'active') {
                        link.find('.label').addClass('label-success')
                    } else {
                        link.find('.label').removeClass('label-success').addClass('label-danger')
                    }
                }
            });
        });

    </script>
@endsection
