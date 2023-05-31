<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

@foreach ($sitemap as $link)
    @if ($link['is_multilanguage'])
        @foreach (Lang::langs() as $lang)
            <url>
                <loc>{{ Lang::url($lang->tag, $link['slug']) }}</loc>
                <priority>{{ $link['priority'] }}</priority>
                    @foreach (Lang::langs() as $lang_for_children) 
                        <xhtml:link 
                            rel="alternate"
                            hreflang="{{ $lang_for_children->tag }}"
                            href="{{ Lang::url($lang_for_children->tag, $link['slug']) }}"/>        
                    @endforeach
            </url>
        @endforeach
    @else
        <url>
            <loc>{{ $link['slug'] }}</loc>
            <priority>{{ $link['priority'] }}</priority>
        </url>
    @endif
@endforeach


</urlset>