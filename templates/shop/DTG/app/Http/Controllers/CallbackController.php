<?php

namespace App\Http\Controllers;

use App\Events\Callback;
use App\Models\CallbackContacts;
use App\Models\CallbackHorizontal;
use App\Models\CallbackModal;
use Illuminate\Http\Request;

class CallbackController extends Controller
{

	public function send_horizontal(Request $r) {
		$input = $r->all();

		$callback_horizontal = new CallbackHorizontal;
		
		$callback_horizontal->name = $input['name'];
		$callback_horizontal->phone = $input['phone'];
		$callback_horizontal->link = $input['link'];
		$callback_horizontal->date = date('Y-m-d H:i:s');
		
		$callback_horizontal->save();

		Callback::dispatch($callback_horizontal);

		return $this->response();
	}

	public function send_contacts(Request $r) {
		$input = $r->all();

		$callback_contacts = new CallbackContacts;
		
		$callback_contacts->name = $input['name'];
		$callback_contacts->phone = $input['phone'];
		$callback_contacts->email = $input['email'];
		$callback_contacts->message = $input['message'];
		$callback_contacts->date = date('Y-m-d H:i:s');
		
		$callback_contacts->save();

		Callback::dispatch($callback_contacts);


		return $this->response();
	}

	public function send_modal(Request $r) {
		$input = $r->all();

		$callback_modal = new CallbackModal;
		
		$callback_modal->name = $input['name'];
		$callback_modal->phone = $input['phone'];
		$callback_modal->message = $input['message'];
		$callback_modal->link = $input['link'];
		if ($input['price'])
			$callback_modal->price = $input['price'];
		else 
			$callback_modal->price = '';

		$callback_modal->date = date('Y-m-d H:i:s');
		
		$callback_modal->save();

		Callback::dispatch($callback_modal);

		return $this->response();
	}
}