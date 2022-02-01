<?php

namespace App\Http\Controllers;

use App\Events\Order as EventsOrder;
use App\Models\Cart\CartHandler;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\View\Components\Cart\Cart as CartComponent;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
	public function checkout () {


		return view('pages.checkout', [
		]); 
	}

	public function change_delivery (Request $r, Delivery $delivery_model) {

		$delivery = $delivery_model->where('slug', $r->get('delivery'))->first();

		$delivery_price = 0;
		if (!empty($delivery)){
			$delivery_price = intval($delivery->price);
		}

		$cart_component = new CartComponent(false, $delivery_price);
		
		return $this->response([
			'cart_checkout'	=> $cart_component->render(),
		]);

	}

	public function order (Request $r, Delivery $delivery_model, Payment $payment_model) {

		$order = new Order();

		$user = Auth::user();
		if (!empty($user))
			$order->id_users = $user->id;
		else
			$order->id_users = 0;

		$order->user_name = $r->get('name');
		$order->user_email = $r->get('email');
		$order->user_phone = $r->get('phone');
		$order->city = $r->get('city');
		$order->region = $r->get('region');
		$order->recall = intval($r->get('recall'));
		$order->status_payment = 0;
		$order->id_orders_status = 1;
		$order->id_order = Order::all()->last()->id + 1;
		$order->id_delivery = $delivery_model->get_by_slug($r->get('delivery'))->id;
		$order->id_payment = $payment_model->get_by_slug($r->get('payment'))->id;
		$order->date = $r->get('date');

		$order->save();
		$id_order = $order->id;

		$cart = new CartHandler();
		$order_products = [];
		foreach ($cart->products() as $cart_product){

			$order_product = new OrderProducts();

			$order_product->id_orders = $id_order;
			$order_product->title = $cart_product->title;
			$order_product->slug = $cart_product->slug;
			$order_product->price = $cart_product->price;
			$order_product->image = $cart_product->image;
			$order_product->count = $cart_product->count;

			$order_products[] = $order_product;

			$order_product->save();
		}

		EventsOrder::dispatch($order, $order_products);

		$cart->clear();
		
		return $this->response([
			'id'	=> $id_order,
		]);

	}
	

}