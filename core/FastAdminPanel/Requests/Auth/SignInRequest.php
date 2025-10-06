<?php

namespace App\FastAdminPanel\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'max:191'/* 'email' */],
            'password' => ['required', 'max:191'],
            'is_remember' => ['required', 'boolean'],
        ];
    }
}
