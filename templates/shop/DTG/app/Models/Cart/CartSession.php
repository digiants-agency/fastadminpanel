<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use Session;

class CartSession extends Model
{
    public function __construct () {	
	}
    
	public function get () {

		$cart = Session::get('cart');

		if (empty($cart) || $cart->count() == 0)
			$cart = collect([]);

		return $cart;
	}

	public function set ($cart_products) {

		Session::put('cart', $cart_products);
	}
}
