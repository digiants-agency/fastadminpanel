<div class="select">
    <div class="select-title color-text" onclick="select_click(this)">{{ $current }}</div>
    <div class="select-items">
        @foreach ($items as $item)
            @if(!$item['active'])
                <div class="select-item color-text" data-href="{{ $item['value'] }}" onclick="{{ $action }}">{{ $item['title'] }}</div>        
            @endif
        @endforeach
    </div>
</div>


@desktopcss
<style>

    .select {
        position: relative;
        min-width: 280px;
        height: 40px;
        cursor: pointer;
    }

    .select-title, 
    .select-item {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 17px;
    }

    .select-title {
        display: flex;
        align-items: center;
        border: 1px solid var(--color-back-and-stroke);
        border-radius: 5px;
        background: var(--color-white);
        padding: 12px 20px;
        position: relative;
    }

    .select-title::after {
        position: absolute;
        right: 17px;
        top: 50%;
        display: block;
        content: "";
        width: 7px;
        height: 7px;
        border: 1px solid var(--color-grey);
        transform: translateY(-50%) rotate(45deg);
        transition: .3s;
        border-left: none;
        border-top: none;
    }

    .select.active .select-title::after {
        margin-top: 3px;
        transform: translateY(-50%) rotate(225deg);
    }

    .select-items{
        position: absolute;
        top: calc(100% + 7px);
        left: 0;
        width: 100%;
        z-index: 100;
        background: #FFFFFF;
        box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.07);
        border-radius: 5px;
        padding: 12px 20px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: .3s;
    }

    .select.active .select-items {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }

    .select-item {
        margin-bottom: 12px;
    }

    .select-item:last-child{
        margin-bottom: 0;
    }


</style>
@mobilecss
<style>

    .select {
        position: relative;
        min-width: 133px;
        height: 30px;
        cursor: pointer;
    }

    .select-title, 
    .select-item {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 16px;
    }

    .select-title {
        display: flex;
        align-items: center;
        border: 1px solid var(--color-back-and-stroke);
        border-radius: 5px;
        background: var(--color-white);
        padding: 7px 6px;
        position: relative;
    }

    .select-title::after {
        position: absolute;
        right: 8px;
        top: 50%;
        display: block;
        content: "";
        width: 5px;
        height: 5px;
        border: 1px solid var(--color-grey);
        transform: translateY(-50%) rotate(45deg);
        transition: .3s;
        border-left: none;
        border-top: none;
        margin-top: -2px;
    }

    .select.active .select-title::after {
        margin-top: 3px;
        transform: translateY(-50%) rotate(225deg);
    }

    .select-items{
        position: absolute;
        top: calc(100% + 5px);
        left: 0;
        width: 100%;
        z-index: 100;
        background: #FFFFFF;
        box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.07);
        border-radius: 5px;
        padding: 6px;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: .3s;
    }

    .select.active .select-items {
        opacity: 1;
        visibility: visible;
        pointer-events: all;
    }

    .select-item {
        margin-bottom: 7px;
    }

    .select-item:last-child{
        margin-bottom: 0;
    }


</style>
@endcss


@js
<script>
    
    function select_click(elm){
        $(elm).parent().toggleClass('active');
    }

    $(document).on('mouseup', function (e) {
		var container = $('.select');
		if (!container.el[0].contains(e.target)){
			container.removeClass('active');
		}
	});

</script>
@endjs