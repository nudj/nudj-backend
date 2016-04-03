@extends('desk.content')

@section('page')

<section class="content-header">
    <h1>
        Static Contents
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Static Contents</li>
    </ol>
</section>

<section class="content">
    <!-- {{$reference}} -->

    <form method="post" action="/staticcontentselement/{{$reference}}">
        <textarea name="text" style="width:100%;height:200px;">{!! $text !!}</textarea>
        <input type="submit" value="update" />
    <form>

</section>

@endsection