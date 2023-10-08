<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Requests\SingleEditRequest;
use App\FastAdminPanel\Requests\SingleRemoveRequest;
use App\FastAdminPanel\Services\Single\SingleGetService;
use App\FastAdminPanel\Services\Single\SingleSetService;
use App\FastAdminPanel\Single\SingleSaver;
use Illuminate\Http\Request;

class SingleController extends \App\Http\Controllers\Controller
{
	public function show(SingleGetService $service, $id)
	{
		$blocks = $service->get($id);

		return $this->response($blocks);
	}
	
	// TODO: validate parameters
	public function update(Request $request, SingleSetService $service)
	{
		$blocks = $request->get('blocks');

		$service->set($blocks);

		return $this->response();
	}

	public function singleEdit(SingleEditRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->save($data['blocks']);

		return $this->response();
	}

	public function singleRemove(SingleRemoveRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->remove();

		return $this->response();
	}
}