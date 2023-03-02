<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Services\Single\SingleGetService;
use App\FastAdminPanel\Services\Single\SingleSetService;
use Illuminate\Http\Request;

class SingleController extends \App\Http\Controllers\Controller
{
	// TODO: validate parameters
	public function put(Request $request, SingleSetService $service, $id)
	{
		$blocks = $request->get('blocks');

		$service->set($blocks);

		return $this->response();
	}

	public function get(SingleGetService $service, $id)
	{
		$blocks = $service->get($id);

		return $this->response($blocks);
	}
}