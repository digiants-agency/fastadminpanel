<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\SingleField;
use App\FastAdminPanel\Single\Api\Getter;
use App\FastAdminPanel\Single\Api\Setter;
use Illuminate\Http\Request;

class SingleController extends \App\Http\Controllers\Controller
{
	public function put(Request $request, SingleField $model, $id)
	{
		$blocks = $request->get('blocks');

		$setter = new Setter($model, $id);

		$setter->set($blocks);

		return $this->response();
	}

	public function get(SingleField $model, $id)
	{
		$getter = new Getter($model, $id);

		$blocks = $getter->get();

		return $this->response($blocks);
	}
}