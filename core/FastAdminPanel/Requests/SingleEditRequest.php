<?php

namespace App\FastAdminPanel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingleEditRequest extends FormRequest
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
            'icon' => strval($this->icon),
            'dropdown_id' => intval($this->dropdown_id),
        ]);
	}

    public function rules()
	{
		$rules = [
            'title'                             => ['required', 'string'],
            'slug'                              => ['required', 'string'],
            'sort'                              => ['required', 'integer'],
            'icon'                              => ['string', 'nullable'],
            'dropdown_id'                       => ['integer', 'nullable'],
            'blocks'                            => ['required', 'array'],
        ];

        return $rules;
    }
}
