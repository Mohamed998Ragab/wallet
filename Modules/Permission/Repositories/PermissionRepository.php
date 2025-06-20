<?php

namespace Modules\Permission\Repositories;

use Modules\Permission\Models\Permission;
use Modules\Permission\Repositories\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
class PermissionRepository implements PermissionRepositoryInterface
{
    public function findByName($name)
    {
        return Permission::where('name', $name)->firstOrFail();
    }

    public function assignToAdmin($adminId, $permissionId)
    {
        Permission::findOrFail($permissionId)->admins()->attach($adminId);
    }

    public function all(): Collection
    {
        return Permission::all();
    }
}