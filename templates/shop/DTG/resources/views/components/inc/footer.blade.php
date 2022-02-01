<footer>
	<div class="container">
		<div class="footer-inner">

			<div class="footer-col">
				<a href="{{ Lang::link('/') }}">
					<img srcset="/images/lazy.svg" src="/images/logo.svg" alt="" class="logo">
				</a>
				<a class="made color-grey" href="https://digiants.agency" target="_blank">Made by DIGIANTS</a>
				<div class="copyright color-grey">{{ $fields['copyright'] }}</div>
			</div>

			<div class="footer-col">
				@foreach ($fields['col1'] as $col1_item)
					<a class="footer-link color-text" href="{{ Lang::link($col1_item[1]) }}">{{ $col1_item[0] }}</a>					
				@endforeach
			</div>

			<div class="footer-col">
				@foreach ($fields['col2'] as $col2_item)
					<a class="footer-link color-text" href="{{ Lang::link($col2_item[1]) }}">{{ $col2_item[0] }}</a>					
				@endforeach
			</div>

			<div class="footer-col">
				@foreach ($fields['col3'] as $col3_item)
					<a class="footer-link color-text" href="{{ Lang::link($col3_item[1]) }}">{{ $col3_item[0] }}</a>					
				@endforeach

				@foreach ($fields['phones'] as $phones_item)
					<a href="tel:{{ Field::phone($phones_item[0]) }}" class="footer-contact-link color-second">{{ $phones_item[0] }}</a>
				@endforeach

				<a href="mailto:{{ $fields['email'] }}" class="footer-contact-link color-second">{{ $fields['email'] }}</a>
				
				<div class="footer-contact-link color-second">{{ $fields['time'] }}</div>
			</div>

			<div class="footer-col footer-col-last">
				<x-inputs.button action="open_modal('callback', '{{ url()->current() }}')">
					{{ $fields['button_text'] }}
				</x-inputs.button>
				<div class="footer-social">
					@foreach ($fields['social'] as $social_item)
						<a href="{{ $social_item[0] }}" target="_blank" class="footer-social-link">
							<img srcset="/images/lazy.svg" src="{{ $social_item[1] }}" alt="" class="footer-social-image">
						</a>
					@endforeach
				</div>
			</div>
			
		</div>
	</div>
</footer>

<x-modals.error />
<x-modals.callback />
<x-modals.cart />
<x-modals.login />
<x-modals.register />
<x-modals.forgot />


<div id="loader">
	<svg  width="40" height="40" viewBox="0 0 50 50">
		<path fill="#black" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
			<animateTransform attributeType="xml"
				attributeName="transform"
				type="rotate"
				from="0 25 25"
				to="360 25 25"
				dur="0.6s"
				repeatCount="indefinite"/>
		</path>
	</svg>
</div>

@desktopcss

<style>

	footer {
		background: var(--color-back-and-stroke);
		padding: 50px 0;
	}

	.footer-inner {
		display: flex;
		justify-content: space-between;
	}

	.made, .copyright {
		font-style: normal;
		font-weight: normal;
		font-size: 14px;
		line-height: 24px;
		white-space: break-spaces;
	}

	.made{
		display: block; 
		margin: 17px 0 15px;
		transition: .3s;
	}

	.made:hover{
		color: #51225D;
	}

	.footer-col {
		display: flex;
		flex-direction: column;
	}

	.footer-col-last {
		align-items: flex-end;
	}

	.footer-link {
		font-style: normal;
		font-weight: normal;
		font-size: 18px;
		line-height: 28px;
		margin-bottom: 10px;
		transition: .3s;
	}

	.footer-link:hover{
		color: var(--color-second);
	}

	.footer-contact-link {
		font-style: normal;
		font-weight: normal;
		font-size: 16px;
		line-height: 26px;
		margin-bottom: 4px;
	}

	.footer-social {
		display: flex;
		align-items: center;
		margin-top: 25px;
	}

	.footer-social-link {
		margin-left: 10px;
		border-radius: 50%;
	}

	.footer-social-image {
		width: 32px;
		height: 32px;
		transition: .3s;
	}

	.footer-social-image:hover {
		filter: hue-rotate(-10deg);
	}

</style>

@mobilecss

<style>

	footer {
		background: var(--color-back-and-stroke);
		padding: 40px 15px;
	}

	.footer-inner {
		display: flex;
		flex-direction: column;
	}

	footer .logo {
		width: 130px;
		height: 56px;
	}

	.made, .copyright {
		font-style: normal;
		font-weight: normal;
		font-size: 12px;
		line-height: 20px;
		white-space: break-spaces;
	}

	.made{
		display: block; 
		margin: 20px 0 9px;
	}

	.footer-col {
		display: flex;
		flex-direction: column;
		margin-bottom: 30px;
	}

	.footer-col:nth-child(1){
		order: 1;
	}
	
	.footer-col:nth-child(5){
		order: 2;
	}

	.footer-col:nth-child(4){
		order: 3;
	}

	.footer-col:nth-child(2){
		order: 4;
	}

	.footer-col:nth-child(3){
		order: 4;
		margin-bottom: 0;
	}

	.footer-col-last {
		align-items: flex-start;
	}

	.footer-link {
		font-style: normal;
		font-weight: normal;
		font-size: 18px;
		line-height: 24px;
		margin-bottom: 10px;
	}

	.footer-contact-link {
		font-style: normal;
		font-weight: normal;
		font-size: 14px;
		line-height: 20px;
		margin-bottom: 6px;
	}

	.footer-social {
		display: flex;
		align-items: center;
		margin-top: 20px;
	}

	.footer-social-link {
		margin-right: 10px;
		border-radius: 50%;
	}

	.footer-social-image {
		width: 35px;
		height: 35px;
		transition: .3s;
	}

</style>

@endcss


@js('0')

<script>

	const $ = function(selector) {

		if (! (this instanceof $) ) {
			return new $(selector);
		}

		if (typeof selector=="object") 
			this.el = [selector]; 
		else 
			this.el = document.querySelectorAll(selector);
		
		return this;
	}

	$.prototype.css = function(prop, val) {
		this.el.forEach(function(element) {
			element.style[prop] = val;
		});
		return this;
	}

	$.prototype.display = function (name){
		this.el.forEach(function(el){
			el.style.display = name
		});
		return this;
	}

	$.prototype.on = function (event, f){
		this.el.forEach(function(el){
			el.addEventListener(event, f)
		});
		return this;
	}

	$.prototype.fadein = function (){
		this.el.forEach(function(el){
			el.classList.add('active')
		});
		return this;
	}

	$.prototype.fadeout = function (){
		this.el.forEach(function(el){
			el.classList.remove('active')
		});
		return this;
	}

	$.prototype.toggleClass = function (classname){
		this.el.forEach(function(el){
			el.classList.toggle(classname)
		});
		return this;
	}

	$.prototype.addClass = function (classname){
		this.el.forEach(function(el){
			el.classList.add(classname)
		});
		return this;
	}

	$.prototype.removeClass = function (classname){
		this.el.forEach(function(el){
			el.classList.remove(classname)
		});
		return this;
	}

	$.prototype.slideUp = function (){
		this.el.forEach(function(el){
			el.style.transition = "all .5s ease-in-out"
			el.style.height = "0px"
			el.setAttribute('data-height',el.offsetHeight)
		});
		return this;
	}

	$.prototype.slideDown = function (){
		this.el.forEach(function(el){
			el.style.transition = "all .5s ease-in-out"
			el.style.height = el.getAttribute('data-height') ?? 'auto'
		});
		return this;
	}

	$.prototype.toggleSlide = function (){
		this.el.forEach(function(el,index){
			el.style.transition = "all 1s ease-in-out"
			console.log(el.offsetHeight);
			if(el.offsetHeight==0) {
				el.style.height = el.getAttribute('data-height') ?? 'auto'
			} else {
				el.style.height = "0px"
				el.setAttribute('data-height',el.offsetHeight)
			}
		});
		return this;
	}

	$.prototype.parent = function (){
		var els = this.el;
		var parents = []
		els.forEach(function(el, index) {
			parents[index] = el.parentElement
		})
		this.el = parents
		return this;
	}

	$.prototype.child = function (){
		var els = this.el;
		var childs = []
		els.forEach(function(el, index) {
			childs[index] = el.firstElementChild
		})
		this.el = childs
		return this;
	}

	$.prototype.val = function(val){
		if ( val !== undefined && val !== null )
			this.el.forEach(function(el, index) {
				el.value = val
			})
	
		return this.el[0].value;
	}

	$.prototype.data = function(attr, val){
		if (val !== undefined && val !== null )
			this.el[0].setAttribute('data-'+attr, val)
		
		return this.el[0].getAttribute('data-'+attr)
	}

	$.prototype.attr = function(attr, val){
		if (val !== undefined && val !== null )
			this.el[0].setAttribute(attr, val)
		
		return this.el[0].getAttribute(attr)
	}

	$.prototype.html = function(html){
		if (html !== undefined && html !== null)
			this.el[0].innerHTML = html
		return this.el[0].innerHTML;
	}

	$.prototype.text = function(text){
		if(text !== undefined && text !== null)
			this.el[0].innerText = text
		return this.el[0].innerText;
	}

	$.prototype.height = function(){
		return this.el[0].offsetHeight
	}

	// document.addEventListener('DOMContentLoaded', function(){

		// lazy load START
			/**
			 * Usage: <img srcset="/images/lazy.svg" src="/images/original.png" alt="">
			 */
			function check_lazy() {
				for (var i = lazy_imgs.length - 1; i >= 0; i--) {
					var img = lazy_imgs[i]
					if (img.srcset == '/images/lazy.svg' && img.getBoundingClientRect().top - 100 < window.innerHeight) {
						(function(img) {
							img.onload = () => {
								img.removeAttribute('srcset')
							}
						})(img)
						img.srcset = img.src
					}
				}
			}
			var lazy_imgs = []
			window.addEventListener('DOMContentLoaded', () => {
				lazy_imgs = Array.prototype.slice.call(document.querySelectorAll('img[srcset]'))
				setTimeout(() => {
					check_lazy()
				}, 200)
			})
			window.addEventListener('scroll', () => {
				check_lazy()
			})
		// lazy load END


		function scrollIt(destination, duration = 500, easing = 'easeInOutCubic', callback) {

			const easings = {
				easeInOutCubic(t) {
					return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
				},
			};

			const start = window.scrollY;
			const startTime = 'now' in window.performance ? performance.now() : new Date().getTime();

			const documentHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.documentElement.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight);
			const windowHeight = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
			const destinationOffset = typeof destination === 'number' ? destination : destination.offsetTop;
			const destinationOffsetToScroll = Math.round(documentHeight - destinationOffset < windowHeight ? documentHeight - windowHeight : destinationOffset);

			if ('requestAnimationFrame' in window === false) {
				window.scroll(0, destinationOffsetToScroll);
				if (callback) {
					callback();
				}
				return;
			}

			function scroll() {
				const now = 'now' in window.performance ? performance.now() : new Date().getTime();
				const time = Math.min(1, ((now - startTime) / duration));
				const timeFunction = easings[easing](time);
				window.scroll(0, Math.ceil((timeFunction * (destinationOffsetToScroll - start)) + start));

				if (Math.abs(window.scrollY - destinationOffsetToScroll) < 2) {
					if (callback) {
						callback();
					}
					return;
				}

				requestAnimationFrame(scroll);
			}

			scroll();
		}


		// ajax request START
			let load_count = 0
			const loader = document.getElementById('loader')

			const serialize = function(obj, prefix) {
				var str = [], p;
				for (p in obj) {
					if (obj.hasOwnProperty(p)) {
					var k = prefix ? prefix + "[" + p + "]" : p,
						v = obj[p];
						str.push((v !== null && typeof v === "object") ?
						serialize(v, k) :
						encodeURIComponent(k) + "=" + encodeURIComponent(v));
					}
				}
				return str.join("&");
			}

			const formdata = function(obj) {

				let formData = new FormData()

				for (const i in obj) {

					formData.append(i, obj[i])
				}

				return formData
			}

			async function post(endpoint, obj, is_file = false, is_loader = true) {
									
				try {

					if (is_loader && loader) {
						load_count++
						loader.classList.add('active')
						// document.dispatchEvent(new CustomEvent('loading', { 'detail': load_count }))
					}

					const url = endpoint

					let headers = {
						'Accept': 'application/json',
						'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
					}

					if (!is_file) {

						// headers['Content-Type'] = 'multipart/form-data'

						var response = await fetch(url, {
							method: 'POST',
							headers: headers,
							body: formdata(obj)
						})

					} else {

						headers['Content-Type'] = 'application/x-www-form-urlencoded'

						var response = await fetch(url, {
							method: 'POST',
							headers: headers,
							body: serialize(obj)
						})
					}
					
					let json = []

					try {

						json = await response.json()

					} catch (error) {}

					if (is_loader && loader) {
						load_count--
						if (load_count == 0)
							loader.classList.remove('active')
						// document.dispatchEvent(new CustomEvent('loading', { 'detail': load_count }))
					}

					if (!json.data) {
						return {
							success: false,
							message: "Fatal error",
							data: json,
						}
					}

					return json

				} catch (error) {

					console.error(error)
				}

				return {success: false, message: "Fatal error", data: {}}
			}
		// ajax request END
		
	// })
</script>

<script>


	function resize () {
        document.body.style.setProperty('--width', document.body.clientWidth)
    }
    resize()
    window.addEventListener('resize', resize)

	if ($('.first-header').el[0])
		$('.body-wrapper').css('min-height', 'calc( 100vh - '+$('footer').height()+'px - '+$('header').height()+'px - '+$('.first-header').height()+'px)')

		
	async function user_logout(){

		const response = await post('/api/logout', {}, true, true);
	
		if (lang)
			document.location.href = lang;
		else 
			document.location.href = '/';

	}

	const Cart = new function() {

		this.add = async(id_product, count, attributes = '') => {

			is_checkout = window.location.href.indexOf("checkout") !== -1

			delivery = ''

			if (is_checkout) {
				delivery = $('input[name="delivery"]:checked').val()
			}

			const response = await post(lang + '/api/add-to-cart', {
				id_product: id_product,
				count: count,
				is_checkout: is_checkout,
				attributes: attributes,
				delivery: delivery,
			})

			if (!response.success) {
				alert('Ошибка')
				return
			}

			$('#mini-cart').html(response.data.minicart)
			$('.header-icons-circle').text(response.data.cart_count)
			$('#mini-cart-price').text(response.data.cart_total)

			if (!is_checkout)
				open_cart_modal();
			else {
				$('#checkout-cart').html(response.data.checkout_cart);
			}

			if (response.data.cart_total > 0){
				$('#checkout-submit').css('display', 'flex')
				$('#cart-submit').css('display', 'flex')
			} else {
				$('#checkout-submit').css('display', 'none')
				$('#cart-submit').css('display', 'none')
			}

		}
	}

	const Saved = new function() {


		this.toggle = async(elm, id_product) => {

			const response = await post('/api/saved', {
				id_product: id_product,
			}, false, false)

			if (response.success) {
				if (response.data.status) {
					elm.classList.add('active')
				} else {
					elm.classList.remove('active')
				}
				if (elm.classList.contains('delete-wished-product') || elm.classList.contains('wished-clear')) {
					location.reload();
				}
				return
			} else {
				open_error_modal()
			}

		}

		this.clear = async() => {
			const response = await post('/api/saved/clear', {})

			if (response.success) {
				location.reload();
			} 
		}

	}

</script>


@endjs

{!! JSAssembler::get() !!}
