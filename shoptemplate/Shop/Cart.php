<?php

namespace App\Shop;

use App\Shop\CartDB;
use App\Shop\CartSession;
use MongoDB\Driver\Session;
use Auth;
use Lang;
use DB;

class Cart {

    protected $products = null;
    protected $user = null;
    protected $driver = '';
    protected $tbl_product;

    public function __construct ($tbl_product, $tbl_cart) {

        $this->user = Auth::user();
        $this->tbl_product = $tbl_product;
        $custom_session = \Illuminate\Support\Facades\Session::getId();

        if (empty($this->user)){
            $this->driver = new CartSession($custom_session,$tbl_cart);
        } else {
            $this->driver = new CartDB($this->user->id, $tbl_cart);
            $this->merge_carts($this->user->id, $custom_session, $tbl_cart);
        }
    }

    public function add ($product, $count, $meta = '') {

        $product_id = $product;

        [$cart_products, $real_product_ids] = $this->rm_products_not_exist_and_get($product_id);

        if ($real_product_ids->contains($product_id)) {

            $cart_product = $cart_products->first(function($val) use ($product_id){
                return $val->id == $product_id;
            });		// get cart product

            $cart_products = $cart_products->reject(function($item, $key) use ($product_id){	// rm it
                return $item->id == $product_id;
            });

            if (empty($cart_product)) {
                $new_count = $count;
            } else {

                $new_count = $cart_product->count + $count;

                if(!empty($meta) && !empty($cart_product->meta)){
                    $meta = $cart_product->meta .' '.$meta;
                }
                if (empty($meta) && !empty($cart_product->meta)) {
                    $meta = $cart_product->meta;
                }
            }

            if ($new_count > 0) {
                $cart_products->push((object)[
                    'id'	=> $product_id,
                    'count'	=> $new_count,
                    'meta'	=> $meta,
                ]);
            }
        }

        $this->driver->set($cart_products);
    }

    public function setqty ($product, $count, $meta = '') {

        $product_id = $product;

        [$cart_products, $real_product_ids] = $this->rm_products_not_exist_and_get($product_id);

        if ($real_product_ids->contains($product_id)) {

            $cart_product = $cart_products->first(function($val) use ($product_id){
                return $val->id == $product_id;
            });		// get cart product

            $cart_products = $cart_products->reject(function($item, $key) use ($product_id){	// rm it
                return $item->id == $product_id;
            });

            $new_count = $count;

            if (empty($meta) && !empty($cart_product->meta)) {
                $meta = $cart_product->meta;
            }
            if ($new_count > 0) {
                $cart_products->push((object)[
                    'id'	=> $product_id,
                    'count'	=> $new_count,
                    'meta'	=> $meta,
                ]);
            }
        }

        $this->driver->set($cart_products);
    }

    public function setnumber($telephone){
        $this->driver->settelephone($telephone);
    }

    public function delete ($product) {

        $product_id = $product;

        [$cart_products, $real_product_ids] = $this->rm_products_not_exist_and_get($product_id);

        if ($real_product_ids->contains($product_id)) {

            $cart_product = $cart_products->first(function($val) use ($product_id){
                return $val->id == $product_id;
            });		// get cart product

            $cart_products = $cart_products->reject(function($item, $key) use ($product_id){	// rm it
                return $item->id == $product_id;
            });
        }

        $this->driver->set($cart_products);
    }

    public function get () {
        return $this->driver->get();
    }

    public function products () {

        if (!empty($this->products))
            return $this->products;

        $cart_products = $this->rm_products_not_exist_and_get();

        $products = DB::table($this->tbl_product)
            ->select(
                'id',
                'slug',
                'title',
                'price',
                'img',
                'sale_price',
                'sku',
                'id_category'
            )->whereIn('id', $cart_products->pluck('id'))
            ->get();

        foreach ($products as &$product) {
            $product->category = DB::table('category')->select('slug')->where('id',$product->id_category)->first();
            $cart_product = $cart_products->first(function($val) use ($product){
                return $val->id == $product->id;
            });
            $product->count = $cart_product->count;
            $product->meta = $cart_product->meta;
        }

        $this->products = $products;

        return $this->products;
    }

    public function total () {

        $products = $this->products();

        $total = 0;

        foreach ($products as $product) {
            if($product->sale_price>0) $total += $product->count * $product->sale_price; else
                $total += $product->count * $product->price;
        }

        return $total;
    }

    public function totalnonsale () {

        $products = $this->products();

        $total = 0;

        foreach ($products as $product) {
            $total += $product->count * $product->price;
        }

        return $total;
    }

    public function sum () {

        $cart_products = $this->rm_products_not_exist_and_get();

        return $cart_products->sum('count');
    }

    public function count () {

        $cart_products = $this->rm_products_not_exist_and_get();

        return $cart_products->count();
    }

    public function clear () {

        $this->driver->set([]);
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

    protected function merge_carts ($userid, $sessid, $tbl_cart) {

        $driver_session = new CartSession($sessid,$tbl_cart);
        $db_session = new CartDb($userid,$tbl_cart);

        $session_cart = $driver_session->get();
        $db_cart = $db_session->get();
        foreach($session_cart as &$sc){
            $sc->id_session=NULL;
            $sc->id_users = $userid;
            $sc->id_product = $sc->id;
            unset($sc->id);
        }
        $session_cart = json_decode(json_encode($session_cart),true);
        DB::table('cart')->where('id_session',$sessid)->delete();
        foreach($session_cart as $ssc){
            $ssc->id = $ssc->cart_product_id;
            unset($ssc->cart_product_id);
            DB::table('cart')->insert($ssc);
        }
    }
}
