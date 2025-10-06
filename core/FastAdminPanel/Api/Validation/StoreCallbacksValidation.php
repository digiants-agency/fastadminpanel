<?php

namespace App\FastAdminPanel\Api\Validation;

use Illuminate\Http\Request;

class StoreCallbacksValidation
{
    public function __construct(
        protected Request $request,
    ) {}

    public function validate()
    {
        $validated = $this->request->validate([
            'name' => ['required', 'max:191'],
            'phone' => ['required', 'max:191'],
        ]);
    }
}
