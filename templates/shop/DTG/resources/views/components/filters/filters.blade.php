<div class="filters mb-100">
    
    <div class="fitler-header">
        
        <svg class="close-filter-svg" id="close_filter" onclick="close_filters()" width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.575736 4.57574C0.341421 4.81005 0.341421 5.18995 0.575736 5.42426L4.39411 9.24264C4.62843 9.47696 5.00833 9.47696 5.24264 9.24264C5.47696 9.00833 5.47696 8.62843 5.24264 8.39411L1.84853 5L5.24264 1.60589C5.47696 1.37157 5.47696 0.991674 5.24264 0.757359C5.00833 0.523045 4.62843 0.523045 4.39411 0.757359L0.575736 4.57574ZM16 4.4L1 4.4V5.6L16 5.6V4.4Z" fill="white"></path>
        </svg>

        <div class="filter-header-title color-white">{{ $fields['filter_title'] }}</div>
    </div>
    
    <div class="filters-content">
        @foreach ($filters as $filter)
            <x-filters.filter :filter="$filter" />
        @endforeach

        <x-filters.priceslider 
            minprice="{{ $minprice }}"
            maxprice="{{ $maxprice }}"
            pricefrom="{{ $pricefrom }}"
            priceto="{{ $priceto }}"
        />

        <a href="{{ $link }}" class="clear-filter color-grey">{{ $fields['clear_filters'] }}</a>
    </div>
    
</div>

@desktopcss
<style>
    
    .filters {
        width: 270px;
        margin-right: 46px;
        flex-shrink: 0;
    }

    .fitler-header {
        display: none;
    }

    .clear-filter {
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 26px;
        margin-top: 15px;
        text-decoration-line: underline;
    }



</style>
@mobilecss
<style>
    
    #filters {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(1, 1, 1, .5);
        display: none;
        justify-content: flex-end;
        z-index: 10000;
        max-height: 100%;
    }

    #filters.active {
        display: flex;
    }


    .filters {
        width: 240px;
        top: 0;
        right: 0;
        background-color: #fff;
        height: 100%;
        overflow-y: scroll;
        border-radius: 5px 0px 0px 0px;
    }

    .fitler-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--color-second);
        padding: 11px 15px;
        position: relative;
        border-radius: 5px 0px 0px 0px;
    }

    .close-filter-svg {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
    }

    .filters-content {
        padding: 0 15px;
    }

    .filter-header-title{
        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 18px;
        text-align: center;
        width: 100%;
    }

    .clear-filter {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 19px;
        margin-top: 12px;
        text-decoration-line: underline;
    }



</style>
@endcss


@startjs
<script>

    async function make_filters(loader = true) {

        let filters = $('input[name="filter-select"]:checked');

        let href = '';

        filters.el.forEach(function(filter, index){
            href += '/' + $($(filter).el[0].closest('.filter')).data('filter') + '--' + $(filter).val()  
        });

        if (parseInt($('#pricelower').val()) >= $('#pricelower').data('price'))
            min_price = $('#pricelower').val()

        if (parseInt($('#pricehight').val()) <= $('#pricehight').data('price'))
            max_price = $('#pricehight').val()

        if (typeof(min_price) != "undefined" && min_price !== null && min_price != $('#pricelower').data('price')) {
            href += '/minprice--'+min_price
        } 

        if (typeof(max_price) != "undefined" && max_price !== null && max_price != $('#pricehight').data('price')) {
            href += '/maxprice--'+max_price
        } 

        const urlParams = new URLSearchParams(window.location.search);
        const sort = urlParams.get('sort')

        if (sort){
            href += '?sort=' + sort
        }

        href = document.location.protocol + '//' + document.location.hostname + $('.clear-filter').attr('href') + href

        const response = await post(href, {is_filters: true}, true, loader)

        if (response.success){
            
            
            $('#content-block').html(response.data.html)

            $('#pagination').html(response.data.pagination)
            
            $('#sort').html(response.data.sort)

            $('#filters').html(response.data.filters)

            $('.btn-filters-count').text(response.data.count_filters)

            history.pushState({}, '', href)

            $('.callback-form input[name="link"]').val(href)

            window.scrollTo({ top: 0, behavior: 'smooth' });

            make_priceslider()

        } else {

        }

        return false


    }

    $('#filters').on('click', function(e){
        if (this == (e.target)) {
            close_filters()
		}
    })

    function close_filters(){
        $('#filters').removeClass('active')
    }

</script>
@endjs