<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Crud;
use App\FastAdminPanel\Policies\MainPolicy;
use App\FastAdminPanel\Requests\Crud\StoreRequest;
use App\FastAdminPanel\Requests\Crud\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CrudController extends Controller
{
	public function index(MainPolicy $policy)
	{
		$cruds = Crud::get();

		$slugs = $policy->getSlugs('admin_read');

		if (!$slugs->contains('all')) {

			$cruds = $cruds->filter(fn ($c) => $slugs->contains($c->table_name))->values();
		}

		return Response::json($cruds);
	}

	public function store(StoreRequest $request)
	{
		$data = $request->validated();

		$crud = Crud::create($data);

		return Response::json($crud);
	}

	public function update(UpdateRequest $request, $table)
	{
		$data = $request->validated();

		$crud = Crud::findOrFail($table);
		$crud->update($data);

		return Response::json();
	}

	public function destroy($table)
	{
		$crud = Crud::findOrFail($table);
		$crud->delete();

		return Response::json();
	}
}