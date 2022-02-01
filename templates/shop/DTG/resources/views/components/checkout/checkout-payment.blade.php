<div class="checkout-block">
    <div class="h4 color-second checkout-block-title">{{ $fields['title'] }}</div>

    @foreach ($payment as $key => $payment_item)
        @if($key == 0)

            <x-inputs.radio 
                :name="'payment'"
                :value="$payment_item->slug"
                :title="$payment_item->title"
                checked  
            />

        @else

            <x-inputs.radio 
                :name="'payment'"
                :value="$payment_item->slug"
                :title="$payment_item->title"
            />
            
        @endif

        
    @endforeach



</div>

@desktopcss
<style>
    

</style>
@mobilecss
<style>
    

</style>
@endcss