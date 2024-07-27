<?php 

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Facades\Single;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class SingleValueApiController extends Controller
{
	public function show($slug)
	{
		$this->authorize('something', [$slug, 'api_read']);

		$single = Single::get($slug);

		if (!$single) {

			return Response::json(null, 404);
		}

		return Response::json($single);
	}
}