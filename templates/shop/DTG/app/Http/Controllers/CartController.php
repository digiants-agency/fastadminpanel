<?php

namespace App\Http\Controllers;

use App\Models\Cart\CartHandler;
use App\Models\Delivery;
use App\View\Components\Cart\Cart as CartComponent;

use Illuminate\Http\Request;

class CartController extends Controller
{
	public function add (Request $r, Delivery $delivery_model) {

		$input = $r->all();
		
		if (empty($input['count']))
			$input['count'] = 1;

		$cart = new CartHandler();
		$cart->add($input['id_product'], $input['count'], $input['attributes']);		

		$delivery = 0;

		if (!empty($input['delivery'])){
			$delivery_price = $delivery_model->where('slug', $input['delivery'])
			->first();

			$delivery = intval($delivery_price->price) ?? 0;
		}

		$cart_component = new CartComponent(true, $delivery);
		$checkout_cart_component = new CartComponent(false, $delivery);

		$cart_count = $cart->count();
		$cart_total = $cart->total();

		if ($input['is_checkout']) {

			return $this->response([
				'minicart'				=> $cart_component->render(),
				'checkout_cart'			=> $checkout_cart_component->render(),
				'cart_count'			=> $cart_count,
				'cart_total'			=> $cart_total,
			]);
		}

		return $this->response([
			'minicart'		=> $cart_component->render(),
			'cart_count'	=> $cart_count,
			'cart_total'	=> $cart_total,
		]);

	}
	

}