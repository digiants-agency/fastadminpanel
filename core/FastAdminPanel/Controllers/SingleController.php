<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Requests\SingleEditRequest;
use App\FastAdminPanel\Requests\SingleRemoveRequest;
use App\FastAdminPanel\Responses\JsonResponse;
use App\FastAdminPanel\Services\Single\SingleGetService;
use App\FastAdminPanel\Services\Single\SingleSetService;
use App\FastAdminPanel\Single\SingleSaver;
use Illuminate\Http\Request;
use Single;

class SingleController extends \App\Http\Controllers\Controller
{
	public function show(SingleGetService $service, $id)
	{
		$blocks = $service->get($id);

		return JsonResponse::response($blocks);
	}
	
	// TODO: validate parameters
	public function update(Request $request, SingleSetService $service)
	{
		$blocks = $request->get('blocks');

		$service->set($blocks);

		return JsonResponse::response();
	}

	public function destroy()
	{
	}

	public function first($slug)
	{
		return JsonResponse::response([
			'single'	=> Single::get($slug),
		]);
	}

	public function singleEdit(SingleEditRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->save($data['blocks']);

		return JsonResponse::response();
	}

	public function singleRemove(SingleRemoveRequest $request)
	{
		$data = $request->validated();

		$saver = new SingleSaver($data);
		$saver->remove();

		return JsonResponse::response();
	}
}