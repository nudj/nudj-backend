<!DOCTYPE html>
<html>
<head>

    @section('title')
        <title>Dashboard</title>
    @show

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    @section('styles')
        <link rel="stylesheet" href="{{ asset('assets/web/js/bootstrap.min.js') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/skins/skin-purple.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/admin/css/overwrite.css') }}">
    @show

</head>

<body>

@yield('content')

@section('scripts')
    <script src="{{ asset('assets/web/js/jquery-2.2.2.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.min.js') }}"></script>
@show

@section('runnable')
@show

</body>

</html>
