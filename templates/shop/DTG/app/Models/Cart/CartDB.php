<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use DB;

class CartDB extends Model
{
    protected $user_id = 0;
	protected $table;

	public function __construct ($user_id, $tbl_cart) {

		$this->user_id = $user_id;
		$this->table = $tbl_cart;
	}

	public function get () {

		return DB::table($this->table)
		->select('id_product AS id', 'count', 'meta')
		->where('id_users', $this->user_id)
		->get();
	}

	public function set ($cart_products) {

		$insert = [];

		foreach ($cart_products as $cart_product) {
			
			$insert[] = [
				'id_users'		=> $this->user_id,
				'id_product'	=> $cart_product->id,	
				'count'			=> $cart_product->count,
				'meta'			=> $cart_product->meta ?? '',
			];
		}

		// TODO: make insert or update
		DB::table($this->table)
		->where('id_users', $this->user_id)
		->delete();

		DB::table($this->table)
		->insert($insert);
	}
}
