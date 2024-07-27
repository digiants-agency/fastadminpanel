<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns:xhtml="http://www.w3.org/1999/xhtml"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
						http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
						http://www.w3.org/TR/xhtml11/xhtml11_schema.html
						http://www.w3.org/2002/08/xhtml/xhtml1-strict.xsd">

@foreach ($sitemap as $link)
	@if ($link['isMultilanguage'])
		@foreach (Lang::all() as $lang)
			<url>
				<loc>{{ Lang::url($lang->tag, $link['url']) }}</loc>
				@foreach (Lang::all() as $childrenLang)
					<xhtml:link 
						rel="alternate"
						hreflang="{{ $childrenLang->tag }}"
						href="{{ Lang::url($childrenLang->tag, $link['url']) }}"/>
				@endforeach
			</url>
		@endforeach
	@else
		<url>
			<loc>{{ $link['url'] }}</loc>
		</url>
	@endif
@endforeach


</urlset>