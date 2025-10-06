<?php

namespace App\FastAdminPanel\Controllers;

use App\FastAdminPanel\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    public function index()
    {
        return Response::json([
            'roles' => Role::get(),
            'id_roles' => Auth::user()->id_roles ?? 0,
        ]);
    }
}
