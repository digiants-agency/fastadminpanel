<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\RolePermission;
use App\FastAdminPanel\Policies\MainPolicy;
use App\FastAdminPanel\Requests\RolePermission\UpdateRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RolePermissionController extends Controller
{
    public function index(MainPolicy $policy)
    {
        $permissions = RolePermission::get();

        if (! $policy->isSuperadmin()) {

            $slugs = $policy->getSlugsByRoleId();

            $permissions = $permissions->filter(fn ($p) => $slugs->contains($p->slug))->values();
        }

        return Response::json($permissions);
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        RolePermission::overwrite($data['permissions']);

        return Response::json();
    }
}
