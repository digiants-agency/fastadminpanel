<div class="product-description-header">
    <div class="h3 color-second product-description-title">{{ $title }}</div>
</div>

<div class="characteristics">
    @foreach ($characteristics as $item)
        <div class="characteristic-item">
            <div class="color-text characteristic-title">{{ $item->title }}:</div>
            <div class="characteristic-dots"></div>
            <div class="main-text color-text chracteristic-value">{{ $item->value }}</div>
        </div> 
    @endforeach
</div>


@desktopcss
<style>
    
    .characteristic-item {
        display: flex;
        align-items: center;
        width: 500px;
        margin-bottom: 10px; 
    }

    .characteristic-item:last-child{
        margin-bottom: 0;
    }

    .characteristic-dots {
        flex-grow: 1;
        border-bottom: 1px dashed var(--color-grey);
        margin: 0 10px;
    }

    .characteristic-title {
        font-style: normal;
        font-weight: 450;
        font-size: 18px;
        line-height: 28px;
    }


</style>
@mobilecss
<style>
    
    .characteristic-item {
        margin-bottom: 12px; 
    }

    .characteristic-item:last-child{
        margin-bottom: 0;
    }

    .characteristic-dots {
        display: none;
    }

    .characteristic-title {
        font-style: normal;
        font-weight: 500;
        font-size: 16px;
        line-height: 18px;
    }


</style>
@endcss