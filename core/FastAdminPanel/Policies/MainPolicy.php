<?php

namespace App\FastAdminPanel\Policies;

use App\FastAdminPanel\Models\Role;
use App\FastAdminPanel\Models\RolePermission;
use Illuminate\Support\Facades\Auth;

class MainPolicy
{
    protected $permissions;

    public function __construct()
    {
        $this->permissions = RolePermission::get();
    }

    public function everything($user = null)
    {
        $roleId = $user->id_roles ?? 0;

        $permission = $this->permissions
            ->first(fn ($p) => $p->id_roles == $roleId && $p->slug == 'all');

        return (bool) $permission;
    }

    public function something($user = null, $slug = '', $permissionName = '')
    {
        $roleId = $user->id_roles ?? 0;

        foreach ($this->permissions as $permission) {

            $isRole = $permission->id_roles == $roleId || $permission->id_roles == 0;
            $isSlug = $permission->slug == $slug || $permission->slug == 'all';
            $isPermitted = $permission->$permissionName || $permission->all;

            if ($isRole && $isSlug && $isPermitted) {

                return true;
            }
        }

        return false;
    }

    public function showAdminpanel($user = null)
    {
        $isAdmin = Role::find($user->id_roles ?? 0)->is_admin ?? 0;

        return $isAdmin == 1;
    }

    public function getSlugs($name)
    {
        $user = Auth::user();

        return $this->permissions->filter(fn ($p) => $p->id_roles == $user->id_roles || $p->id_roles == 0)
            ->filter(fn ($p) => $p->$name == 1 || $p->all == 1)
            ->map(fn ($p) => $p->slug);
    }

    public function getSlugsByRoleId($roleId = -1)
    {
        $user = Auth::user();
        $roleId = $roleId == -1 ? ($user->id_roles ?? 0) : $roleId;

        return $this->permissions->filter(fn ($p) => $p->id_roles == $roleId || $p->id_roles == 0)
            ->map(fn ($p) => $p->slug);
    }

    public function isSuperadmin()
    {
        $user = Auth::user();

        return $this->everything($user);
    }
}
