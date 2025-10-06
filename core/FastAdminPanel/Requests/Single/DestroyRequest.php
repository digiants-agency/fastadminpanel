<?php

namespace App\FastAdminPanel\Requests\Single;

use App\FastAdminPanel\Models\SinglePage;
use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    public function rules()
    {
        return [
            'slug' => ['required', 'string', 'in:'.SinglePage::get(['slug'])->pluck('slug')->implode(',')],
        ];
    }
}
