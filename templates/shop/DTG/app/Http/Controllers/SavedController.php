<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saved\SavedHandler;

class SavedController extends Controller
{
	public function saved (Request $r) {

		$input = $r->all();
        
		$saved = new SavedHandler();
		
		switch ($saved->toggle($input['id_product'])) {
			case 'Saved':
				return $this->response(['status' => true]);
				break;

			case 'Removed':
				return $this->response(['status' => false]);
				break;
		}

		return $this->error();
	}

	public function clear (Request $r) {

		$saved = new SavedHandler();
		$saved->clear();

		return $this->response();
	} 
}
