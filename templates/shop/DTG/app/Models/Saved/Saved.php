<?php

namespace App\Models\Saved;

use Illuminate\Database\Eloquent\Model;
use Lang;
use DB;
use Illuminate\Support\Facades\Auth;

class Saved extends Model
{
    protected $table = 'saved';

    protected $tbl_saved;
	protected $tbl_product;
	protected $saved = null;

	public function __construct ($tbl_saved, $tbl_product) {

		$this->tbl_saved = $tbl_saved;
		$this->tbl_product = $tbl_product.'_'.Lang::get();
	}

	public function toggle ($product_id) {

		$user = Auth::user();

		if(!empty($user)){

			$saved = DB::table($this->tbl_saved)
			->where('id_products', $product_id)
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
					'id_products'	=> $product->id,
					'id_users'		=> $user->id,
				]);
	
				return 'Saved';
	
			}
	
			DB::table($this->tbl_saved)
			->where('id_products', $product_id)
			->where('id_users', $user->id)
			->delete();
			
			return 'Removed';
		}else{
			return 'Not user';
		}
		
	}


	public function clear (){

		DB::table($this->tbl_saved)
		->where('id_users', Auth::user()->id)
		->delete();
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
			->whereIn('id', $this->saved->pluck('id_products'))
			->get()
			->pluck('id');

			foreach ($this->saved as $key => $saved) {

				$products_to_delete = [];

				if (!$products->contains($saved->id_products)) {

					$products_to_delete[] = $saved->id_products;
					$this->saved->forget($key);
				}

				DB::table($this->tbl_saved)
				->whereIn('id_products', $products_to_delete)
				->delete();
			}

		} else {

			$this->saved = collect([]);
		}

		return $this->saved;
	}

	protected function rm_products_not_exist_and_get ($product_id = -1) {

		$saved_products = $this->driver->get();
		$count = $saved_products->count();

		$real_product_ids = DB::table($this->tbl_product)
		->select('id')
		->whereIn('id', $saved_products->pluck('id')->merge([$product_id]))
		->get()
		->pluck('id');

		// rm products, that doesnt exist in DB
		foreach ($saved_products as $key => $saved_product) {
			if (!$real_product_ids->contains($saved_product->id)) {
				$saved_products->forget($key);
			}
		}

		if ($count != $saved_products->count())
			$this->driver->set($saved_products);

		if ($product_id != -1)
			return [$saved_products, $real_product_ids];
		return $saved_products;
	}
}
