<!DOCTYPE html>

<html>
<head>
	<!-- Title -->
	<title>{{ $title }}</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="description" content="Description">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<!-- Styles -->
	@section('styles')
		<!-- Just an example -->
		<link href="{{ asset('assets/web/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/web/css/select/bootstrap-select.css') }}" rel="stylesheet">
		<link href="{{ $local_css }}" rel="stylesheet">
	@show

</head>

<body>


@yield('page')


<!-- JS -->
@section('scripts')
	<!-- Just an example -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="{{ asset('assets/web/js/bootstrap.js') }}"></script>
	<script src="{{ asset('assets/web/js/select/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('assets/web/js/custom.js') }}"></script>
@show

@section('runnable')

@show

</body>
</html>