<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

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

@if (Lang::langs()->count() > 1)
	@foreach (Lang::langs() as $lang)
		<link rel="alternate" hreflang="{{$lang->tag}}" href="{{Lang::url($lang->tag)}}"/>
	@endforeach
@endif

<script>
	var is_mobile = {{ Platform::mobile() ? 'true' : 'false'}}
	var lang = document.querySelector('html').getAttribute('lang')
</script>