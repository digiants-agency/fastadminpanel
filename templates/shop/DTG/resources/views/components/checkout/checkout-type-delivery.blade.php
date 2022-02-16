<div class="checkout-block">
    <div class="h4 color-second checkout-block-title">{{ $fields['title'] }}</div>

    @foreach ($delivery as $key => $delivery_item)
        @if($key == 0)

            <x-inputs.radio 
                :name="'delivery'"
                :value="$delivery_item->slug"
                :title="$delivery_item->title"
                :description="$delivery_item->description"
                :price="$delivery_item->price"
                checked  
            />

        @else

            <x-inputs.radio 
                :name="'delivery'"
                :value="$delivery_item->slug"
                :title="$delivery_item->title"
                :description="$delivery_item->description"
                :price="$delivery_item->price"
            />
            
            <x-checkout.checkout-delivery />
            
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


@js
    <script>
        
        $('input[name="delivery"]').on('change', async function(){
            
            const response = await post(lang + '/api/change-delivery', {
                delivery: $(this).val()
            }, true, true)

            if (response.success){
                $('#checkout-cart').html(response.data.cart_checkout)
            } else {

            }
            
        })

    </script>
@endjs