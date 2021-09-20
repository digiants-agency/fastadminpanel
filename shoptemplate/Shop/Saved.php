<?php 

namespace App\Shop;

use Lang;
use Auth;
use DB;

class Saved {

	protected $tbl_saved;
	protected $tbl_product;
	protected $saved = null;

	public function __construct ($tbl_saved, $tbl_product) {

		$this->tbl_saved = $tbl_saved;
		$this->tbl_product = $tbl_product.'_'.Lang::get();
	}

	public function toggle ($product_id) {

		$user = Auth::user();

		$saved = DB::table($this->tbl_saved)
		->where('id_product', $product_id)
		->where('id_users', $user->id)
		->first();

		if (empty($saved)) {

			$product = DB::table($this->tbl_product)
			->select('id')
			->where('id', $product_id)
			->first();

			if (empty($product)) {

				return 'Error';
			}

			DB::table($this->tbl_saved)
			->insert([
				'id_product'	=> $product->id,
				'id_users'		=> $user->id,
			]);

			return 'Saved';

		}

		DB::table($this->tbl_saved)
		->where('id_product', $product_id)
		->where('id_users', $user->id)
		->delete();
		
		return 'Removed';
	}

	public function get () {

		if ($this->saved != null)
			return $this->saved;

		$user = Auth::user();
		if (!empty($user)) {

			$this->saved = DB::table($this->tbl_saved)
			->where('id_users', $user->id)
			->get();

			$products = DB::table($this->tbl_product)
			->select('id')
			->whereIn('id', $this->saved->pluck('id_product'))
			->get()
			->pluck('id');

			foreach ($this->saved as $key => $saved) {

				$products_to_delete = [];

				if (!$products->contains($saved->id_product)) {

					$products_to_delete[] = $saved->id_product;
					$this->saved->forget($key);
				}

				DB::table($this->tbl_saved)
				->whereIn('id_product', $products_to_delete)
				->delete();
			}

		} else {

			$this->saved = collect([]);
		}

		return $this->saved;
	}

	protected function rm_products_not_exist_and_get ($product_id = -1) {

		$cart_products = $this->driver->get();
		$count = $cart_products->count();

		$real_product_ids = DB::table($this->tbl_product)
		->select('id')
		->whereIn('id', $cart_products->pluck('id')->merge([$product_id]))
		->get()
		->pluck('id');

		// rm products, that doesnt exist in DB
		foreach ($cart_products as $key => $cart_product) {
			if (!$real_product_ids->contains($cart_product->id)) {
				$cart_products->forget($key);
			}
		}

		if ($count != $cart_products->count())
			$this->driver->set($cart_products);

		if ($product_id != -1)
			return [$cart_products, $real_product_ids];
		return $cart_products;
	}
}