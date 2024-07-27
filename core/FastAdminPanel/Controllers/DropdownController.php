<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Dropdown;
use App\FastAdminPanel\Requests\Dropdown\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DropdownController extends Controller
{
	public function index()
	{
		$dropdowns = Dropdown::get();

		return Response::json($dropdowns);
	}

	public function update(UpdateRequest $request)
	{
		$data = $request->validated();
		
		Dropdown::overwrite($data['dropdowns']);

		return Response::json();
	}
}