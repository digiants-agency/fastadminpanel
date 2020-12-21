<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}">

@yield('meta')
@yield('meta-directions')

<link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">

@foreach ($_GET as $param => $val)
	@if (strncmp($param, 'utm_', 4) === 0 || $param == 'gclid')
		<meta name="robots" content="noindex,nofollow"/>
	@endif
@endforeach

@if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'facebook') !== false)
	<meta property="og:image" content="{{url('/images/og-fb.jpg')}}">
@else
	<meta property="og:image" content="{{url('/images/og.jpg')}}">
@endif

@if (Lang::get_langs()->count() > 1)
	@foreach (Lang::get_langs() as $lang)
		<link rel="alternate" hreflang="{{$lang->tag}}" href="{{Lang::get_url($lang->tag)}}"/>
	@endforeach
@endif

<script>
var is_mobile = {{(Agent::isMobile() && !Agent::isTablet()) ? 'true' : 'false'}}
</script>

@if (Agent::isMobile() && !Agent::isTablet())
	<link rel="stylesheet" href="<?php include 'css/converter-mobile.php' ?>">
@else
	<link rel="stylesheet" href="<?php include 'css/converter-desktop.php' ?>">
@endif