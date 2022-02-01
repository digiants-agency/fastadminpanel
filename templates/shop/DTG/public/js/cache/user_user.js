 


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




;
 

    async function edit_user(form, route) {

        name = $(form.querySelector('input[name="name"]')).val()
        surname = $(form.querySelector('input[name="surname"]')).val()
        login = $(form.querySelector('input[name="login"]')).val()
        email = $(form.querySelector('input[name="email"]')).val()
        phone = $(form.querySelector('input[name="phone"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()
        password_confirmation = $(form.querySelector('input[name="password_confirmation"]')).val()

        const response = await post(route, {
            name: name,
            surname: surname,
            login: login,
            email: email,
            phone: phone,
            password: password,
            password_confirmation: password_confirmation
        }, true, true)

        if (response.success) {
            $(form.querySelector('.message.error')).css('display', 'none')

            $(form.querySelector('.message.success')).css('display', 'block')

        } else {
            $(form.querySelector('.message.success')).css('display', 'none')

            $(form.querySelector('.message.error')).css('display', 'block')

            if (response.data.password){
                $(form.querySelector('.message.error')).text(response.data.password[0])
            } else if (response.data.phone) {
                $(form.querySelector('.message.error')).text(response.data.phone[0])
            } else if (response.data.email) {
                $(form.querySelector('.message.error')).text(response.data.email[0])
            } else if (response.data.password_confirmation) {
                $(form.querySelector('.message.error')).text(response.data.password_confirmation[0])
            }
        }

    }


;
 

    async function change_user_menu(route){
        
        const response = await post(route, {}, true, true)

        if (response.success){
            
            $('#user-navigation').html(response.data.navigation)

            if (screen.width > 900)
                $('#user-content').html(response.data.content)

            url = document.location.protocol + '//' + document.location.hostname + route
            history.pushState({}, '', url)

        } else {

        } 


    }


;
 
    if (is_mobile){

        $('.menu-item-wrapper-parent').on('click', function(e){

            if (e.target == $(this).child().el[0] && (e.target.classList.contains('back'))){

                e.preventDefault()

                that = $(this).child().el[0]

                submenu = $(that).parent().el[0].querySelector('.submenu')

                $(that).removeClass('back')
                $(submenu).removeClass('active')
                if (that.closest('ul').classList.contains('menu')){
                    $('header').removeClass('with-submenu')
                    $('.header-menu-langs-and-user').css('display', 'flex')
                }

                let items = that.closest('ul').children

                if (that.closest('ul').closest('li'))
                    $(that.closest('ul').closest('li')).child('.menu-item.back').css('display', 'flex')

                for (var i = 0; i < items.length; i++){
                    // if(!items[i].classList.contains('menu-item-wrapper-parent'))
                    //     $(items[i]).css('display', 'flex');
                    // if (items[i] != this_li.el[0]) {
                    //     $(items[i]).css('display', 'flex');
                    // }
                    if(!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'flex');
                    else {
                        $(items[i]).css('display', 'block');
                    }
                    
                }
            }
        })

        $('.menu-item-parent-svg').on('click', function (e) {
            e.preventDefault()
            submenu = $(this).parent().parent().el[0].querySelector('.submenu')
            this_li = $(this).parent().parent()
            
            if (!$(this).parent().el[0].classList.contains('back')){

                $(submenu).addClass('active')
                $(this).parent().addClass('back')
                $('header').addClass('with-submenu')
                $('.header-menu-langs-and-user').css('display', 'none')

                let items = this.closest('ul').children
                console.log(items)
                console.log(1)
                if (this.closest('ul').closest('li'))
                    $(this.closest('ul').closest('li')).child('.menu-item.back').css('display', 'none')


                for (var i = 0; i < items.length; i++){
                    if (items[i] != this_li.el[0]) {
                        $(items[i]).css('display', 'none');
                    }
                    // if (!items[i].classList.contains('menu-item-wrapper-parent'))
                    //     $(items[i]).css('display', 'none');
                }

            } else {

                $(this).parent().removeClass('back')
                $(submenu).removeClass('active')
                if (this.closest('ul').classList.contains('menu')){
                    $('header').removeClass('with-submenu')
                    $('.header-menu-langs-and-user').css('display', 'flex')
                }

                let items = this.closest('ul').children

                if (this.closest('ul').closest('li'))
                    $(this.closest('ul').closest('li')).child('.menu-item.back').css('display', 'flex')

                for (var i = 0; i < items.length; i++){
                    // if (items[i] != this_li.el[0]) {
                    // if (items[i] != this_li.el[0]) {
                    //     $(items[i]).css('display', 'flex');
                    // }
                    // }
                    if(!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'flex');
                    else {
                        $(items[i]).css('display', 'block');
                    }
                }

            }

        });


    }

;
 
	
	$('.search-icon').on('click', function(){
		$(this).parent('form').el[0].submit();
	})

	$('.header-icons-search').on('click', function(){
		$('.search-form').css('display', 'block')
	})

	$('.search-clear').on('click', function(){
		$('.search-form').css('display', 'none')
	})

	$('#search-input').on('input', async function(){
		value = $(this).val()

		

		const response = await post(lang + '/api/search', {value: value}, false, false)

		if (response.success){
			$('.search-form-items').css('display', 'block')
			if (response.data.html){
				$('.non-search-text').css('display', 'none')
				$('.search-form-items-inner').css('display', 'block')
				$('.search-form-items-inner').html(response.data.html)
			} else {
				$('.search-form-items-inner').css('display', 'none')
				$('.non-search-text').css('display', 'block')
			} 

		} else {

		}

		if (!value){
			$('.search-form-items').css('display', 'none')
		}

	})

	$(document).on('mouseup', function (e) {
		var container = $('.search-form-items');
		if (!container.el[0].contains(e.target)){
			container.css('display', 'none');
		}
	});

	$('.toggle-menu').on('click', function(){
		$('header').toggleClass('active')
		$('body').toggleClass('blocked')
		// $('.header-wrapper').css('height', 'calc(' + $('header .container').height() + 'px + ' + $('#mobile-menu').height() + 'px)')
		$('.header-wrapper').toggleClass('active')

	})

	const appHeight = () => {
		const doc = document.documentElement
		doc.style.setProperty('--app-height', `${window.innerHeight}px`)
	}
	window.addEventListener('resize', appHeight)
	appHeight()

	const stickyElm = document.querySelector('header')

	const observer = new IntersectionObserver( 
		([e]) => e.target.classList.toggle('sticky', e.intersectionRatio < 1),
		{threshold: [1]}
	);

	observer.observe(stickyElm)


;
 

    $('.login-modal-recall').on('click', function(){
        close_modal()
        open_login_modal()
    })

    $('.register-modal-recall').on('click', function(){
        close_modal()
        open_register_modal()
    })

    function open_error_modal(){

        close_modal()

        modal = '#modal-error'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }


;
 
    
    $('.callback-form').on('submit', async function(e){
        e.preventDefault()

        name = $(this).el[0].querySelectorAll('input[name="name"]')[0].value
        phone = $(this).el[0].querySelectorAll('input[name="phone"]')[0].value
        message = $(this).el[0].querySelectorAll('textarea[name="message"]')[0].value
        link = $(this).el[0].querySelectorAll('input[name="link"]')[0].value
        price = $(this).el[0].querySelectorAll('input[name="price"]')[0].value

        
        const response = await post(lang + '/api/send-modal', {
            name: name,
            phone: phone,
            message: message,
            link: link,
            price: price,
        }, true, true)

        
        if (response.success){
            
            $($(this).el[0].querySelectorAll('.form-answer.error')[0]).css('display', 'none')
            $($(this).el[0].querySelectorAll('.form-answer.success')[0]).css('display', 'block')

            $(this).el[0].reset()
        } else {
            $($(this).el[0].querySelectorAll('.form-answer.error')[0]).css('display', 'none')
            $($(this).el[0].querySelectorAll('.form-answer.success')[0]).css('display', 'block')
        }

        return false;
    })

    function open_modal(modal, link, with_price = false){

        modal = '#modal-'+modal

        if (link)
            $(modal).el[0].querySelectorAll('input[name="link"]')[0].value = link

        if (with_price)
            $(modal).el[0].querySelectorAll('input[name="price"]')[0].value = $('#price').text()

        $('.form-answer').css('display', 'none')

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }

    function close_modal() {
        $('.modal').removeClass('active');
    }

    $('.modal').on('click', function(e) {
        if (this == (e.target)) {
            close_modal()
        }
    })
    

;
 

    function open_cart_modal(){

        modal = '#modal-cart'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');

    }

    function close_modal() {
        $('.modal').removeClass('active');
    }

    $('.modal').on('click', function(e) {
        if (this == (e.target)) {
            close_modal()
        }
    })
    

;
 

    function open_login_modal(){

        close_modal()

        modal = '#modal-login'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }


    async function user_login(form, route){
        
        email = $(form.querySelector('input[name="email"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()

        
        const response = await post(route, {
            email: email,
            password: password,
        }, true, true)

        if (response.success){

            location.href = response.data.redirect
        
        } else {
            $(form.querySelector('.form-answer.error')).css('display', 'block')
        }

        return false;
    } 


;
 

    function open_register_modal(){

        close_modal()

        modal = '#modal-register'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }
    
    async function user_register(form, route){
        
        name = $(form.querySelector('input[name="name"]')).val()
        email = $(form.querySelector('input[name="email"]')).val()
        phone = $(form.querySelector('input[name="phone"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()

        
        const response = await post(route, {
            email: email,
            password: password,
            name: name,
            phone: phone,
        }, true, true)

        if (response.success){

            location.href = response.data.redirect
        
        } else {

            $(form.querySelector('.form-answer.error')).css('display', 'block')

            if (response.data.password){
                $(form.querySelector('.form-answer.error')).text(response.data.password[0])
            } else if (response.data.phone) {
                $(form.querySelector('.form-answer.error')).text(response.data.phone[0])
            } else if (response.data.email) {
                $(form.querySelector('.form-answer.error')).text(response.data.email[0])
            } 

        }

        return false;
    } 


;
 

    function open_forgot_modal(){

        close_modal()

        modal = '#modal-forgot'

        $(modal).addClass('active')

        scroll_top = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
        $($(modal).el[0].querySelector('.container-modal')).css('top', 'calc(' + scroll_top + 'px + 10vh)');
    }

    async function send_code (form, route, title){
        
        email = $(form.querySelector('input[name="email"]')).val()
        
        const response = await post(route, {
            email: email,
            title: title,
        }, true, true)

        if (response.success){
            $(form.querySelector('.form-answer.error')).css('display', 'none')
            $(form).removeClass('active')
            $('#check-code').addClass('active')

        } else {
            $(form.querySelector('.form-answer.error')).css('display', 'block')
        }

        return false;

    }

    async function check_code (form, route){
        
        email = $($('#send-code').el[0].querySelector('input[name="email"]')).val()
        
        code = $(form.querySelector('input[name="code"]')).val()


        const response = await post(route, {
            email: email,
            code: code,
        }, true, true)

        if (response.success){
            $(form.querySelector('.form-answer.error')).css('display', 'none')
            $(form).removeClass('active')
            $('#change-password').addClass('active')

        } else {
            $(form.querySelector('.form-answer.error')).css('display', 'block')
        }

        return false;

    }

    async function change_password (form, route){
        
        email = $($('#send-code').el[0].querySelector('input[name="email"]')).val()
        code = $($('#check-code').el[0].querySelector('input[name="code"]')).val()
        password = $(form.querySelector('input[name="password"]')).val()
        password_confirmation = $(form.querySelector('input[name="password_confirmation"]')).val()

        const response = await post(route, {
            email: email,
            code: code,
            password: password,
            password_confirmation: password_confirmation,
        }, true, true)

        if (response.success){
            $(form.querySelector('.form-answer.error')).css('display', 'none')
            $(form).removeClass('active')
            $('#send-code').addClass('active')

            close_modal()
            open_login_modal()
            
        } else {

            $(form.querySelector('.form-answer.error')).css('display', 'block')

            if (response.data.password){
                $(form.querySelector('.form-answer.error')).text(response.data.password[0])
            } else if (response.data.phone) {
                $(form.querySelector('.form-answer.error')).text(response.data.phone[0])
            } else if (response.data.email) {
                $(form.querySelector('.form-answer.error')).text(response.data.email[0])
            } else if (response.data.password_confirmation) {
                $(form.querySelector('.form-answer.error')).text(response.data.password_confirmation[0])
            } 

        }

        return false;

    }


;
