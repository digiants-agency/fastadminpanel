<?php

namespace App\FastAdminPanel\Responses;

class JsonResponse
{
    public static function response($result = []) {
		
		$response = [
			'success' => true,
			'data'    => $result,
		];
		
		return response()->json($response, 200);
	}

	public static function error($error_messages = [], $code = 418) {

		$response = [
			'success'	=> false,
			'data'		=> $error_messages,
		];

		return response()->json($response, $code);
	}
}