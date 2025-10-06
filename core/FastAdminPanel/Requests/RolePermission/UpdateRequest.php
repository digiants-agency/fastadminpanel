<?php

namespace App\FastAdminPanel\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'permissions' => ['required', 'array'],
            'permissions.*.id' => ['required', 'integer', 'between:0,1000000'],
            'permissions.*.slug' => ['required', 'max:191'],
            'permissions.*.id_roles' => ['required', 'integer', 'between:0,1000000'],
            'permissions.*.admin_read' => ['required', 'integer', 'between:0,1'],
            'permissions.*.admin_edit' => ['required', 'integer', 'between:0,1'],
            'permissions.*.api_create' => ['required', 'integer', 'between:0,1'],
            'permissions.*.api_read' => ['required', 'integer', 'between:0,1'],
            'permissions.*.api_update' => ['required', 'integer', 'between:0,1'],
            'permissions.*.api_delete' => ['required', 'integer', 'between:0,1'],
            'permissions.*.all' => ['required', 'integer', 'between:0,1'],
        ];
    }
}
