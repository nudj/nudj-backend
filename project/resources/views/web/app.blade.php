<!DOCTYPE html>

<html>
<head>
	<!-- Title -->
	@section('title')
		<title>Default Title</title>
	@show

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="description" content="Description">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">


	<!-- Styles -->
	@section('styles')
		<link href="{{ asset('assets/web/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/web/css/select/bootstrap-select.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/web/css/tiny-modal/tiny_style.css') }}" rel="stylesheet">
	@show

	@section('scriptses')
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	@show
</head>

<body>


@yield('page')


<!-- JS -->
@section('scripts')
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="{{ asset('assets/web/js/bootstrap.js') }}"></script>
	<script src="{{ asset('assets/web/js/select/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('assets/web/js/tiny-modal/tinybox.js') }}"></script>
@show

@section('runnable')

@show

</body>
</html>