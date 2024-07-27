<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Requests\Api\IndexRequest;
use App\FastAdminPanel\Requests\Api\ShowRequest;
use App\FastAdminPanel\Requests\Api\StoreRequest;
use App\FastAdminPanel\Requests\Api\UpdateRequest;
use App\FastAdminPanel\Services\ApiService;
use App\FastAdminPanel\Services\FilterQueryBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(IndexRequest $request, $slug)
	{
		$this->authorize('something', [$slug, 'api_read']);

		$data = $request->validated();

		$crud = Crud::findOrFail($slug);

		$service = new ApiService($crud);

		$filters = new FilterQueryBuilder($request);

		$items = $service->index($data, $filters);
		
		return Response::json($items);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreRequest $request, $slug)
	{
		$this->authorize('something', [$slug, 'api_create']);

		$data = $request->validated();
		
		$crud = Crud::findOrFail($slug);

		$service = new ApiService($crud);

		$item = $service->store($data);

		return Response::json($item); 
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(ShowRequest $request, $slug, $id)
	{
		$this->authorize('something', [$slug, 'api_read']);

		$data = $request->validated();
		
		$crud = Crud::findOrFail($slug);

		$service = new ApiService($crud);

		$item = $service->show($id, $data);
		
		return Response::json($item, $item ? 200 : 404);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $slug, $id)
	{
		$this->authorize('something', [$slug, 'api_update']);

		$data = $request->validated();
		
		$crud = Crud::findOrFail($slug);

		$service = new ApiService($crud);

		$item = $service->update($id, $data);

		return Response::json($item); 
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $slug, $id)
	{
		$this->authorize('something', [$slug, 'api_delete']);

		$crud = Crud::findOrFail($slug);

		$service = new ApiService($crud);

		$service->destroy($id);

		return Response::json();
	}
}