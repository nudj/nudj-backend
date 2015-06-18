<!DOCTYPE html>

<html>
<head>
	<!-- Title -->
	<title>Title</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="description" content="Description">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<!-- Styles -->
	@section('styles')
		<!-- Just an example -->
		<link href="{{ asset('assets/web/css/some.css') }}" rel="stylesheet">
	@show

</head>

<body>


@yield('page')


<!-- JS -->
@section('scripts')
	<!-- Just an example -->
	<script src="{{ asset('assets/web/js/some.js') }}"></script>
@show

@section('runnable')
@show

</body>
</html>