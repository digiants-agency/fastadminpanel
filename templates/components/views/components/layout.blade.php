<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
	
	<head>
		@include('inc.head')

		<title>{{ $meta_title }}</title>
		<meta name="description" content="{{ $meta_description }}">
		<meta name="keywords" content="{{ $meta_keywords }}">
		
		{!! SEO::robots() !!}
		{!! SEO::link_prev() !!}
		{!! SEO::link_next() !!}
		
		%convertor%
        
	</head>

	<body style="--width: 0;">

		<x-inc.header />

		<div class="body-wrapper">
			{{ $slot }}
		</div>

		<x-inc.footer />

		{{ $javascript }}
		
	</body>
    
</html>