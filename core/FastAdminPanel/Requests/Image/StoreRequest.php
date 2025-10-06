<?php

namespace App\FastAdminPanel\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'upload' => ['required', 'image', 'max:10000'],
        ];
    }
}
