@if(sizeof($filter->filter_fields))
    <div class="filter @if($filter->active) active @endif" data-filter="{{ $filter->slug }}">
        <div class="h5 color-text filter-title" onclick="toggle_filter(this)">{{ $filter->title }}</div>
        <div class="filter-fields">
            @foreach($filter->filter_fields as $filter_field)
                <div class="main-text color-text filter-field">
                    @if($filter_field->checked)
                        <x-inputs.checkbox name="filter-select" value="{{ $filter_field->slug }}" checked onchange="make_filters()">
                            {{ $filter_field->title }}
                        </x-inputs.checkbox>
                    @else
                        <x-inputs.checkbox name="filter-select" value="{{ $filter_field->slug }}" onchange="make_filters()">
                            {{ $filter_field->title }}
                        </x-inputs.checkbox>    
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif


@desktopcss
<style>
    
    .filter {
        padding: 15px 0;
        border-bottom: 1px solid var(--color-back-and-stroke);
    }

    .filter-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding-right: 24px;
        position: relative;
        cursor: pointer;
    }

    .filter-title:after {
        content: '';
        display: block;
        width: 12px;
        height: 1px;
        background: var(--color-text);
    }

    .filter-title:before {
        position: absolute;
        right: 24px;
        top: 50%;
        content: '';
        display: block;
        width: 12px;
        height: 1px;
        background: var(--color-text);
        transition: .3s;
        transform: translateY(-50%) rotate(90deg);
        opacity: 1;
    }

    .filter.active .filter-title::before {
        transform: translateY(-50%);
        opacity: 0;
    }

    .filter-fields {
        width: 270px;
        padding-right: 15px;
        max-height: 0;
        overflow-y: auto;
        visibility: hidden;
        transition: .5s;
    }

    .filter-fields::-webkit-scrollbar {
        width: 5px;
    }

    .filter-fields::-webkit-scrollbar-track {
        background: var(--color-back-and-stroke);
    }

    .filter-fields::-webkit-scrollbar-thumb {
        background: var(--color-second);
    }

    .filter.active .filter-fields {
        max-height: 270px;
        visibility: visible;
    }

    .filter.active:nth-child(2n) .filter-fields {
        max-height: 230px;
    }

    .filter-field {
        margin-top: 4px;
        width: 250px;
    }


</style>
@mobilecss
<style>
    
    .filter {
        padding: 15px 0 7px;
        border-bottom: 1px solid var(--color-back-and-stroke);
    }


    .filter-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding-right: 4px;
        position: relative;
        cursor: pointer;
        font-style: normal;
        font-weight: 600;
        font-size: 14px;
        line-height: 18px;
        padding-right: 24px;
        margin-bottom: 8px;
    }

    .filter-title:after {
        content: '';
        display: block;
        width: 12px;
        height: 1px;
        background: var(--color-text);
    }

    .filter-title:before {
        position: absolute;
        right: 24px;
        top: 50%;
        content: '';
        display: block;
        width: 11px;
        height: 1px;
        background: var(--color-text);
        transition: .3s;
        transform: translateY(-50%) rotate(90deg);
        opacity: 1;
    }

    .filter.active .filter-title::before {
        transform: translateY(-50%);
        opacity: 0;
    }

    .filter-fields {
        width: 210px;
        padding-right: 15px;
        max-height: 0;
        overflow-y: auto;
        visibility: hidden;
        transition: .5s;
    }

    .filter-fields::-webkit-scrollbar {
        width: 5px;
    }

    .filter-fields::-webkit-scrollbar-track {
        background: var(--color-back-and-stroke);
    }

    .filter-fields::-webkit-scrollbar-thumb {
        background: var(--color-second);
    }

    .filter.active .filter-fields {
        max-height: 188px;
        visibility: visible;
    }

    .filter.active:nth-child(2n) .filter-fields {
        max-height: 230px;
    }

    .filter-field {
        margin-top: 4px;
        width: 190px;
    }

    .filter-field:last-child{
        margin-bottom: 8px;
    }


</style>
@endcss

@js
<script>

    function toggle_filter(elm) {
        $(elm).parent('.filter').toggleClass('active')
    }


</script>
@endjs