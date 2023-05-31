<div {{ $attributes->merge([ 'class' => 'breadcrumbs '.$type  ]) }}> 
    <div class="container">
        <ul class="breadcrumbs-inner">
            @foreach ($breadcrumbs as $index => $item)
                <li class="breadcrumbs-item">
                    @if($index < sizeof($breadcrumbs) - 1)
                        <a href="{{ $item['link'] }}" class="breadcrumbs-link">
                            {{ $item['title'] }}
                        </a>
                    @else
                        <div class="breadcrumbs-link breadcrumbs-last">
                            {{ $item['title'] }}
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>


<script type="application/ld+json">
    @json($json)
</script>


@desktopcss
<style>

    .breadcrumbs {
        background: var(--color-back-and-stroke);
        margin-bottom: 40px;
        padding: 5px 0;
    }

    .breadcrumbs-inner {
        display: inline;
        list-style: none;
    }

    .breadcrumbs-item {
        display: inline;
    }

    .breadcrumbs-link {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 20px;
        color: var(--color-grey);
        display: inline;
    }

    .breadcrumbs-link::after{
        content: "/";
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 20px;
        color: var(--color-grey);
        margin: 0 2.1px;
    }

    .breadcrumbs-last::after{
        display: none;
    }

    .breadcrumbs-last{
        color: var(--color-text);
    }

</style>
@mobilecss
<style>

    .breadcrumbs {
        background: var(--color-back-and-stroke);
        margin-bottom: 25px;
        padding: 7px 0;
    }

    .breadcrumbs-inner {
        display: inline;
        list-style: none;
    }

    .breadcrumbs-item {
        display: inline;
    }

    .breadcrumbs-link {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 16px;
        color: var(--color-grey);
        display: inline;
    }

    .breadcrumbs-link::after{
        content: "/";
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 16px;
        color: var(--color-grey);
        margin: 0 2.5px;
    }

    .breadcrumbs-last::after{
        display: none;
    }

    .breadcrumbs-last{
        color: var(--color-text);
    }

</style>
@endcss


