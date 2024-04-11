<?php

namespace App\FastAdminPanel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
 
	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
            
        ]);
	}

    public function rules()
	{
		$rules = [
            'table_name'        => ['required'],
        ];

        return $rules;
    }
}
