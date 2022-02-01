 


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
 

    function toggle_filter(elm) {
        $(elm).parent('.filter').toggleClass('active')
    }



;
 

    ! function() {
        "use strict";
        var t = function(t) {
            this.input = null, this.inputDisplay = null, this.slider = null, this.sliderWidth = 0, this.sliderLeft = 0, this.pointerWidth = 0, this.pointerR = null, this.pointerL = null, this.activePointer = null, this.selected = null, this.scale = null, this.step = 0, this.tipL = null, this.tipR = null, this.timeout = null, this.valRange = !1, this.values = {
                start: null,
                end: null
            }, this.conf = {
                target: null,
                values: null,
                set: null,
                range: !1,
                width: null,
                scale: !0,
                labels: !0,
                tooltip: !0,
                step: null,
                disabled: !1,
                onChange: null
            }, this.cls = {
                container: "rs-container",
                background: "rs-bg",
                selected: "rs-selected",
                pointer: "rs-pointer",
                scale: "rs-scale",
                noscale: "rs-noscale",
                tip: "rs-tooltip"
            };
            for (var i in this.conf) t.hasOwnProperty(i) && (this.conf[i] = t[i]);
            this.init()
        };
        t.prototype.init = function() {
            return "object" == typeof this.conf.target ? this.input = this.conf.target : this.input = document.getElementById(this.conf.target.replace("#", "")), this.input ? (this.inputDisplay = getComputedStyle(this.input, null).display, this.input.style.display = "none", this.valRange = !(this.conf.values instanceof Array), !this.valRange || this.conf.values.hasOwnProperty("min") && this.conf.values.hasOwnProperty("max") ? this.createSlider() : console.log("Missing min or max value...")) : console.log("Cannot find target element...")
        }, t.prototype.createSlider = function() {
            return this.slider = i("div", this.cls.container), this.slider.innerHTML = '<div class="rs-bg"></div>', this.selected = i("div", this.cls.selected), this.pointerL = i("div", this.cls.pointer, ["dir", "left"]), this.scale = i("div", this.cls.scale), this.conf.tooltip && (this.tipL = i("div", this.cls.tip), this.tipR = i("div", this.cls.tip), this.pointerL.appendChild(this.tipL)), this.slider.appendChild(this.selected), this.slider.appendChild(this.pointerL), this.conf.range && (this.pointerR = i("div", this.cls.pointer, ["dir", "right"]), this.conf.tooltip && this.pointerR.appendChild(this.tipR), this.slider.appendChild(this.pointerR)), this.input.parentNode.insertBefore(this.slider, this.input.nextSibling), this.conf.width && (this.slider.style.width = parseInt(this.conf.width) + "px"), this.sliderLeft = this.slider.getBoundingClientRect().left, this.sliderWidth = this.slider.clientWidth, this.pointerWidth = this.pointerL.clientWidth, this.conf.scale || this.slider.classList.add(this.cls.noscale), this.setInitialValues()
        }, t.prototype.setInitialValues = function() {
            if (this.disabled(this.conf.disabled), this.valRange && (this.conf.values = s(this.conf)), this.values.start = 0, this.values.end = this.conf.range ? this.conf.values.length - 1 : 0, this.conf.set && this.conf.set.length && n(this.conf)) {
                var t = this.conf.set;
                this.conf.range ? (this.values.start = this.conf.values.indexOf(t[0]), this.values.end = this.conf.set[1] ? this.conf.values.indexOf(t[1]) : null) : this.values.end = this.conf.values.indexOf(t[0])
            }
            return this.createScale()
        }, t.prototype.createScale = function(t) {
            this.step = this.sliderWidth / (this.conf.values.length - 1);
            for (var e = 0, s = this.conf.values.length; e < s; e++) {
                var n = i("span"),
                    l = i("ins");
                n.appendChild(l), this.scale.appendChild(n), n.style.width = e === s - 1 ? 0 : this.step + "px", this.conf.labels ? l.innerHTML = this.conf.values[e] : 0 !== e && e !== s - 1 || (l.innerHTML = this.conf.values[e]), l.style.marginLeft = l.clientWidth / 2 * -1 + "px"
            }
            return this.addEvents()
        }, t.prototype.updateScale = function() {
            this.step = this.sliderWidth / (this.conf.values.length - 1);
            for (var t = this.slider.querySelectorAll("span"), i = 0, e = t.length; i < e; i++) t[i].style.width = this.step + "px";
            return this.setValues()
        }, t.prototype.addEvents = function() {
            var t = this.slider.querySelectorAll("." + this.cls.pointer),
                i = this.slider.querySelectorAll("span");
            e(document, "mousemove touchmove", this.move.bind(this)), e(document, "mouseup touchend touchcancel", this.drop.bind(this));
            for (var s = 0, n = t.length; s < n; s++) e(t[s], "mousedown touchstart", this.drag.bind(this));
            for (var s = 0, n = i.length; s < n; s++) e(i[s], "click", this.onClickPiece.bind(this));
            return window.addEventListener("resize", this.onResize.bind(this)), this.setValues()
        }, t.prototype.drag = function(t) {
            if (t.preventDefault(), !this.conf.disabled) {
                var i = t.target.getAttribute("data-dir");
                return "left" === i && (this.activePointer = this.pointerL), "right" === i && (this.activePointer = this.pointerR), this.slider.classList.add("sliding")
            }
        }, t.prototype.move = function(t) {
            if (this.activePointer && !this.conf.disabled) {
                var i = ("touchmove" === t.type ? t.touches[0].clientX : t.pageX) - this.sliderLeft - this.pointerWidth / 2;
                return (i = Math.round(i / this.step)) <= 0 && (i = 0), i > this.conf.values.length - 1 && (i = this.conf.values.length - 1), this.conf.range ? (this.activePointer === this.pointerL && (this.values.start = i), this.activePointer === this.pointerR && (this.values.end = i)) : this.values.end = i, this.setValues()
            }
        }, t.prototype.drop = function() {
            this.activePointer = null
        }, t.prototype.setValues = function(t, i) {
            var e = this.conf.range ? "start" : "end";
            return t && this.conf.values.indexOf(t) > -1 && (this.values[e] = this.conf.values.indexOf(t)), i && this.conf.values.indexOf(i) > -1 && (this.values.end = this.conf.values.indexOf(i)), this.conf.range && this.values.start > this.values.end && (this.values.start = this.values.end), this.pointerL.style.left = this.values[e] * this.step - this.pointerWidth / 2 + "px", this.conf.range ? (this.conf.tooltip && (this.tipL.innerHTML = this.conf.values[this.values.start], this.tipR.innerHTML = this.conf.values[this.values.end]), this.input.value = this.conf.values[this.values.start] + "," + this.conf.values[this.values.end], this.pointerR.style.left = this.values.end * this.step - this.pointerWidth / 2 + "px") : (this.conf.tooltip && (this.tipL.innerHTML = this.conf.values[this.values.end]), this.input.value = this.conf.values[this.values.end]), this.values.end > this.conf.values.length - 1 && (this.values.end = this.conf.values.length - 1), this.values.start < 0 && (this.values.start = 0), this.selected.style.width = (this.values.end - this.values.start) * this.step + "px", this.selected.style.left = this.values.start * this.step + "px", this.onChange()
        }, t.prototype.onClickPiece = function(t) {
            if (!this.conf.disabled) {
                var i = Math.round((t.clientX - this.sliderLeft) / this.step);
                return i > this.conf.values.length - 1 && (i = this.conf.values.length - 1), i < 0 && (i = 0), this.conf.range && i - this.values.start <= this.values.end - i ? this.values.start = i : this.values.end = i, this.slider.classList.remove("sliding"), this.setValues()
            }
        }, t.prototype.onChange = function() {
            var t = this;
            this.timeout && clearTimeout(this.timeout), this.timeout = setTimeout(function() {
                if (t.conf.onChange && "function" == typeof t.conf.onChange) return t.conf.onChange(t.input.value)
            }, 10)
        }, t.prototype.onResize = function() {
            return this.sliderLeft = this.slider.getBoundingClientRect().left, this.sliderWidth = this.slider.clientWidth, this.updateScale()
        }, t.prototype.disabled = function(t) {
            this.conf.disabled = t, this.slider.classList[t ? "add" : "remove"]("disabled")
        }, t.prototype.getValue = function() {
            return this.input.value
        }, t.prototype.destroy = function() {
            this.input.style.display = this.inputDisplay, this.slider.remove()
        };
        var i = function(t, i, e) {
                var s = document.createElement(t);
                return i && (s.className = i), e && 2 === e.length && s.setAttribute("data-" + e[0], e[1]), s
            },
            e = function(t, i, e) {
                for (var s = i.split(" "), n = 0, l = s.length; n < l; n++) t.addEventListener(s[n], e)
            },
            s = function(t) {
                var i = [],
                    e = t.values.max - t.values.min;
                if (!t.step) return console.log("No step defined..."), [t.values.min, t.values.max];
                for (var s = 0, n = e / t.step; s < n; s++) i.push(t.values.min + s * t.step);
                return i.indexOf(t.values.max) < 0 && i.push(t.values.max), i
            },
            n = function(t) {
                return !t.set || t.set.length < 1 ? null : t.values.indexOf(t.set[0]) < 0 ? null : !t.range || !(t.set.length < 2 || t.values.indexOf(t.set[1]) < 0) || null
            };
        window.rSlider = t
    }();



    var mySliderPrice = null
    
    function make_priceslider(){

        var minValprice = parseInt($('#pricelower').data('price'));
        var maxValprice = parseInt($('#pricehight').data('price'));
        var isFirstTime = 0
        var lastTimeout = 0

        mySliderPrice = new rSlider({

            target: '#priceslider',
            values: { min: minValprice, max: maxValprice },
            step: 5,
            range: true,
            tooltip: true,
            scale: true,
            labels: false,

            onChange: function(vals) {                
                
                var valsarr = vals.split(',');

                if(parseInt($('#pricelower').val()) == valsarr[0] && parseInt($('#pricehight').val()) == valsarr[1])
                    return false

                $('#pricelower').val(parseInt(valsarr[0]));
                $('#pricehight').val(parseInt(valsarr[1]));
                

                if (isFirstTime != 0){
                    
                    clearTimeout(lastTimeout)

                    lastTimeout = setTimeout(function(){
                        make_filters()
                    }, 1000)

                } else {
                    isFirstTime++
                }
                
            }
        });

        mySliderPrice.setValues(parseInt($('#pricelower').val()), parseInt($('#pricehight').val()));
        mySliderPrice.onResize();

    } 

    make_priceslider()
    

    // $('.priceslider-input').on('input', function() {
    //     mySliderPrice.setValues(parseInt($('#pricelower').val()), parseInt($('#pricehight').val()));
    // });



;
 

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


;
 
    
    function select_click(elm){
        $(elm).parent().toggleClass('active');
    }

    $(document).on('mouseup', function (e) {
		var container = $('.select');
		if (!container.el[0].contains(e.target)){
			container.removeClass('active');
		}
	});


;
 
    
    async function make_sort(elm){
        let href = window.location.href.split('?')[0] + '?sort=' + $(elm).data('href')
        
        const response = await post(href, {is_sort: true}, true, true)

        if (response.success){
            
            
            $('#content-block').html(response.data.html)

            $('#pagination').html(response.data.pagination)

            $('#sort').html(response.data.sort)

            history.pushState({}, '', href)

            $('.callback-form input[name="link"]').val(href)

            window.scrollTo({ top: 0, behavior: 'smooth' });

        } else {

        }

        return false



    }


;
 
    
    function open_filters(){
        $('#filters').addClass('active')
        mySliderPrice.onResize();
    }


;
 
     

    async function make_pagination(elm, showmore = false){

        let href = $(elm).child().attr('href')

        const response = await post(href, {}, true, true)

        if (response.success){
            
            if (showmore){
                
                html = $('#content-block').child().html()
                
                const elem = document.createElement('div');
                $(elem).addClass('showmore-content')
                $(elem).html(response.data.html)
                request_html = $(elem).child().html()
                elem.remove()
                
                $('#content-block').child().html(html + request_html)

            } else {
                $('#content-block').html(response.data.html)
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            $('#pagination').html(response.data.pagination)

            url = document.location.protocol + '//' + document.location.hostname + href
            history.pushState({}, '', url)

            $('.callback-form input[name="link"]').val(url)


        } else {

        }

        return false

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
                }

                let items = that.closest('ul').children

                if (that.closest('ul').closest('li'))
                    $(that.closest('ul').closest('li')).child('.menu-item.back').css('display', 'flex')

                for (var i = 0; i < items.length; i++){
                    if(!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'flex');
                }
            }
        })

        $('.menu-item-parent-svg').on('click', function (e) {
            e.preventDefault()
            submenu = $(this).parent().parent().el[0].querySelector('.submenu')

            if (!$(this).parent().el[0].classList.contains('back')){

                $(submenu).addClass('active')
                $(this).parent().addClass('back')
                $('header').addClass('with-submenu')

                let items = this.closest('ul').children

                if (this.closest('ul').closest('li'))
                    $(this.closest('ul').closest('li')).child('.menu-item.back').css('display', 'none')

                for (var i = 0; i < items.length; i++){
                    if (!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'none');
                }

            } else {

                $(this).parent().removeClass('back')
                $(submenu).removeClass('active')
                if (this.closest('ul').classList.contains('menu')){
                    $('header').removeClass('with-submenu')
                }

                let items = this.closest('ul').children

                if (this.closest('ul').closest('li'))
                    $(this.closest('ul').closest('li')).child('.menu-item.back').css('display', 'flex')

                for (var i = 0; i < items.length; i++){
                    if(!items[i].classList.contains('menu-item-wrapper-parent'))
                        $(items[i]).css('display', 'flex');
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
