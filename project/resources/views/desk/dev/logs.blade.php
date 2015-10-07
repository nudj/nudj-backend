@extends('desk.content')

@section('page')

    <section class="content-header">
        <h1>Logs</h1>
    </section>

    <section class="content">
        <div class="box">

            <div class="box-header with-border">
                <h3 class="box-title">Last 20 requests</h3>
            </div>

            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <th>TYPE</th>
                        <th>Endpoint</th>
                        <th>From</th>
                        <th>Token</th>
                        <th>Received At</th>
                    </tr>

                    @foreach($records as $record)
                    <tr>
                        <td>{{$record->id}}</td>
                        <td>{{$record->type}}</td>
                        <td>{{$record->endpoint}}</td>
                        <td>{{$record->from}}</td>
                        <td>{{$record->token}}</td>
                        <td>{{$record->created_at}}</td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


        </div>


    </section>
@endsection

