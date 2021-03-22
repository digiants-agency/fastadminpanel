<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
	<head>
		@include('inc.head')
		@yield('head')
	</head>
	<body>
		@include('inc.header')
		@yield('content')
		@include('inc.footer')
		@yield('javascript')
	</body>
</html>