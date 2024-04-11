<?php

namespace App\FastAdminPanel\Requests;

use App\FastAdminPanel\Models\SinglePage;
use Illuminate\Foundation\Http\FormRequest;

class SingleRemoveRequest extends FormRequest
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
 
    public function rules()
	{
		$rules = [
            'slug' => ['required', 'string', 'in:'.SinglePage::get(['slug'])->pluck('slug')->implode(',')],
        ];

        return $rules;
    }
}
