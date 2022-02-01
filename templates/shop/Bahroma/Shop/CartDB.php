<?php

namespace App\Shop;

use DB;

class CartDB {

	protected $user_id = 0;
	protected $table;

	public function __construct ($user_id, $tbl_cart) {

		$this->user_id = $user_id;
		$this->table = $tbl_cart;
	}

	public function get () {

		return DB::table($this->table)
		->select('id as cart_product_id','id_product AS id', 'count', 'meta')
		->where('id_users', $this->user_id)
        ->orderBy('cart_product_id','desc')
		->get();
	}

	public function set ($cart_products) {

		$insert = [];
        $existsproducts = [];
		foreach ($cart_products as $cart_product) {

			$insert[] = [
				'id_users'		=> $this->user_id,
				'id_product'	=> $cart_product->id,
				'count'			=> $cart_product->count,
				'meta'			=> $cart_product->meta ?? '',
			];
			$existsproducts[] = $cart_product->id;
		}


        DB::table($this->table)->whereNotIn('id_product',$existsproducts)->where('id_users',$this->user_id)->delete();

//		TODO: change updateorinsert to faster function

		foreach($insert as $i){
		    DB::table($this->table)->updateOrInsert(
		        ['id_users'=>$i['id_users'],'id_product'=>$i['id_product']],
                ['count'=>$i['count'],'meta'=>$i['meta']]
            );
        }
	}
}
