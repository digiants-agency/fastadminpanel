<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function response($result = []) {
		
		$response = [
			'success' => true,
			'data'    => $result,
		];
		
		return response()->json($response, 200);
	}

	protected function error($error_messages = [], $code = 418) {

		$response = [
			'success'	=> false,
			'data'		=> $error_messages,
		];

		return response()->json($response, $code);
	}

}