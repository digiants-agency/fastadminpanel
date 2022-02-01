<div class="checkout-block">
    <div class="h4 color-second checkout-block-title">{{ $fields['title'] }}</div>

    <label for="city" class="color-text extra-text checkout-input-label">{{ $fields['label_1'] }}</label>
    <x-inputs.input name="city" type="text" placeholder="{{ $fields['input_1'] }}" required/>

    <label for="region" class="color-text extra-text checkout-input-label">{{ $fields['label_2'] }}</label>
    <x-inputs.input name="region" type="text" placeholder="{{ $fields['input_2'] }}" required/>

</div>

@desktopcss
<style>
    

</style>
@mobilecss
<style>
    

</style>
@endcss