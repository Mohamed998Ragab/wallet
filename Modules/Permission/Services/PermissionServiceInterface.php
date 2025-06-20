<?php

namespace Modules\Permission\Services;

use Illuminate\Database\Eloquent\Collection;

interface PermissionServiceInterface
{
    public function all(): Collection;
    public function hasPermission($adminId, $permissionName);
    public function assignPermission($adminId, $permissionName);
}
