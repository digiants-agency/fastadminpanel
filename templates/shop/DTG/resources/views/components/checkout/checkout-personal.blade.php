<div class="checkout-block">
    <div class="h4 color-second checkout-block-title">{{ $fields['title'] }}</div>

    <label for="name" class="color-text extra-text checkout-input-label">{{ $fields['label_1'] }}</label>
    <x-inputs.input name="name" type="text" placeholder="{{ $fields['input_1'] }}" required value="{{ $user->name ?? '' }}" />

    <label for="phone" class="color-text extra-text checkout-input-label">{{ $fields['label_2'] }}</label>
    <x-inputs.input name="phone" type="phone" placeholder="{{ $fields['input_2'] }}" pattern="^[+ 0-9]+$" title="+380681234567" required value="{{ $user->phone ?? '' }}"/>

    <label for="email" class="color-text extra-text checkout-input-label">{{ $fields['label_3'] }}</label>
    <x-inputs.input name="email" type="email" placeholder="{{ $fields['input_3'] }}" required value="{{ $user->email ?? '' }}"/>
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
	$('#checkout-form').on('submit', async function(e){
		e.preventDefault()

        name = this.querySelector('input[name="name"]').value
        email = this.querySelector('input[name="email"]').value
        phone = this.querySelector('input[name="phone"]').value
        city = this.querySelector('input[name="city"]').value
        region = this.querySelector('input[name="region"]').value
        delivery = this.querySelector('input[name="delivery"]:checked').value
        payment = this.querySelector('input[name="payment"]:checked').value
        
        date = new Date()

        date_format = date.getFullYear() + '-' + 
                        ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                        date.getDate() + ' ' + 
                        date.getHours() + ':' + 
                        date.getMinutes() + ':' + 
                        date.getSeconds()

        if (this.querySelector('input[name="recall"]:checked') != null)
            recall = 1
        else 
            recall = 0
        
		const response = await post('/api/order', {
            name: name,
            email: email,
            phone: phone,
            city: city,
            region: region,
            delivery: delivery,
            payment: payment,
            recall: recall,
            date: date_format,
        }, true, true)

        if (response.success) {

            location.href = '/thanks?id='+response.data.id
        
        } else {

        }

		return false;
	})
</script>
@endjs