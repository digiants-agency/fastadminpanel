<?php

namespace App\FastAdminPanel\Requests\Api;

use App\FastAdminPanel\Models\Crud;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Route;

class ApiRequest extends FormRequest
{
	protected $crud;

	public function __construct()
	{
		// $slug = $this->route('slug'); // doesnt work
		$slug = Route::input('slug');
		$this->crud = Crud::findOrFail($slug);
	}

	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(
			response()->json($validator->errors(), 422)
		);
	}
}
