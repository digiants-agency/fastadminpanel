<?php 

namespace App\Models\Cart;

class CartHandler extends Cart {

	public function __construct () {
		parent::__construct('products', 'cart');
	}

	public function discount () {

		$discount = 0;

		$products = $this->products();

		foreach ($products as $product) {
			if (!empty($product->sale_price) && $product->sale_price != 0) {
				$discount += $product->sale_price - $product->price;
			}
		}

		return $discount;
	}
}