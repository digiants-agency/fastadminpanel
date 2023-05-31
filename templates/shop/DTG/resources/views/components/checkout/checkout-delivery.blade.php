<div class="checkout-block novaya-pochta">
    {{-- <div class="h4 color-second checkout-block-title">{{ $fields['title'] }}</div> --}}

    <div class="novaya-pochta-city">
        <label for="city" class="color-text extra-text checkout-input-label">{{ $fields['label_1'] }}</label>
        <x-inputs.input name="city" id="city" type="text" placeholder="{{ $fields['input_1'] }}" autocomplete="none"/>
        <div class="input-group-autocomplete input-group-autocomplete-city"></div>
    </div>

    <div class="novaya-pochta-city">
        <label for="department" class="color-text extra-text checkout-input-label">{{ $fields['label_2'] }}</label>
        <x-inputs.input name="department" id="department" type="text" placeholder="{{ $fields['input_2'] }}" autocomplete="none"/>
        <div class="input-group-autocomplete input-group-autocomplete-department"></div>
    </div>
    
</div>

@desktopcss
<style>
    .novaya-pochta {
        display: none;
    }

    .novaya-pochta.active {
        display: block;
    }

    .novaya-pochta-city {
        position: relative;
    }

    .input-group-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        max-height: 200px;
        display: none;
        flex-direction: column;
        background: #fff;
        border-radius: 30px;
        z-index: 300;
        padding: 15px 20px;
        font-size: 16px;
        line-height: 21px;
        border: 1px solid var(--color-back-and-stroke);
    }

    .input-group-autocomplete-item {
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 21px;
        margin: 10px 0;
        cursor: pointer;
        transition: .3s;
    }

    .input-group-autocomplete-wrapper {
        overflow: auto;
        max-height: 200px;
    }

    .input-group-autocomplete-item:hover {
        color: var(--color-second);
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar {
        width: 5px;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar-thumb {
        color: var(--color-second);
        padding-right: 5px;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar-thumb {
        background: var(--color-second);
    }

</style>

@mobilecss
<style>
    
    .novaya-pochta {
        display: none;
    }

    .novaya-pochta.active {
        display: block; 
    }

    .novaya-pochta-city {
        position: relative;
    }

    .input-group-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        max-height: 200px;
        overflow: auto;
        display: none;
        flex-direction: column;
        background: #fff;
        border-radius: 20px;
        z-index: 300;
        padding: 15px 20px;
        font-size: 12px;
        line-height: 18px;
        border: 1px solid var(--color-back-and-stroke);
    }

    .input-group-autocomplete-item {
        font-style: normal;
        font-weight: normal;
        font-size: 12px;
        line-height: 18px;
        margin: 8px 0;
        cursor: pointer;
        transition: .3s;
    }

    
    .input-group-autocomplete-wrapper {
        overflow: auto;
        max-height: 200px;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar {
        width: 5px;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar-thumb {
        background: var(--color-second);
        padding-right: 5px;
    }

    .input-group-autocomplete-wrapper::-webkit-scrollbar-thumb {
        background: var(--color-second);
    }

    .input-group.repair-place {
        margin-bottom: 15px;
        width: 100%;
        padding: 0;
    }


</style>
@endcss

@startjs

<script>

    function getCity(elm){
        $('#city').val($(elm).text());
        $('.input-group-autocomplete').css('display', 'none')
        $('#city').attr('value', $(elm).attr('value'));
    }

    function getWarehouse(elm){
        $('#department').val($(elm).text());
        $('.input-group-autocomplete').css('display', 'none')
        $('#department').attr('value', $(elm).attr('value'));
    }

    $('#city').on('input', async function() {

        var input = $(this).val()

        const response = await post("{{ Lang::link('/api/get-city') }}", {city: input }, false, false)
        
        if (response.success){
            $('.input-group-autocomplete-city').css('display', 'flex')
            $('.input-group-autocomplete-city').html(response.data.html)
        }else {
            $('.input-group-autocomplete-city').css('display', 'flex')
            if(lang == 'uk')
            $('.input-group-autocomplete-city').html('За вашим запитом нічого не знайдено!');
            else
            $('.input-group-autocomplete-city').html('По вашему запросу ничего не найдено!');
        }

        return false;
    })

    $('#department').on('input', async function() {
        
        var input = $(this).val()
        var city = $('#city').attr('value');

        const response = await post("{{ Lang::link('/api/get-department') }}", {warehouse: input, city: city }, false, false)
        
        if (response.success){
            $('.input-group-autocomplete-department').css('display', 'flex')
            $('.input-group-autocomplete-department').html(response.data.html)
        }else {
            $('.input-group-autocomplete-department').css('display', 'flex')
            if(lang == 'uk')
            $('.input-group-autocomplete-department').html('За вашим запитом нічого не знайдено!');
            else
            $('.input-group-autocomplete-department').html('По вашему запросу ничего не найдено!');
        }

        return false;
    })


</script>
@endjs