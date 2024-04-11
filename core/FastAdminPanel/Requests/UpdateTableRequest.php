<?php

namespace App\FastAdminPanel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTableRequest extends FormRequest
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
            'dropdown_id'       => empty($this->dropdown_id) ? 0 : intval($this->dropdown_id),
            'icon'              => strval($this->icon),
            'is_dev'            => intval($this->is_dev),
            'multilanguage'     => intval($this->multilanguage),
            'is_soft_delete'    => intval($this->is_soft_delete),
            'sort'              => intval($this->sort),
            'id'                => intval($this->id),
        ]);
	}

    public function rules()
	{
		$rules = [
            'id'                => ['required', 'integer'],
            'table_name'        => ['required'],
            'title'             => ['required'],
            'fields'            => ['required', 'array'],
            'is_dev'            => ['required', 'integer'],
            'multilanguage'     => ['required', 'integer'],
            'is_soft_delete'    => ['required', 'integer'],
            'sort'              => ['required', 'integer'],
            'dropdown_id'       => ['required', 'integer'],
            'icon'              => ['nullable'],
            'to_remove'         => ['array'],
        ];

        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        return array_merge(
            parent::validated(), 
            [
                'fields'    => json_encode($this->fields),
                'to_remove' => json_encode($this->to_remove),
            ]
        );
    }
}
