<!DOCTYPE html>

<html>
<head>
	<!-- Title -->
	<title>Nudge API Monitoring</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="description" content="Your description">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">



	<!-- Styles -->
	@section('styles')
		<!-- Bootstrap CSS -->
		<link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="{{ asset('assets/admin/css/font-awesome.min.css') }}" rel="stylesheet">
		<!-- Custom Color CSS -->
		<link href="{{ asset('assets/admin/css/less-style.css') }}" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

		<link href="{{ asset('assets/admin/css/additional.css') }}" rel="stylesheet">

	@show

</head>

<body>


@yield('page')


<!-- JS -->
@section('scripts')
	<script src="{{ asset('assets/admin/js/jquery.js') }}"></script>
	<!-- Bootstrap JS -->
	<script src="{{ asset('assets/admin/js/bootstrap.min.js') }}"></script>
	<!-- Respond JS for IE8 -->
	<script src="{{ asset('assets/admin/js/respond.min.js') }}"></script>
	<!-- HTML5 Support for IE -->
	<script src="{{ asset('assets/admin/js/html5shiv.js') }}"></script>

@show

@section('runnable')
@show

</body>
</html>