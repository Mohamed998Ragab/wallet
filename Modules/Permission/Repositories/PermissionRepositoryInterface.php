<?php

namespace Modules\Permission\Repositories;
use Illuminate\Database\Eloquent\Collection;
interface PermissionRepositoryInterface
{
    public function findByName($name);
    public function assignToAdmin($adminId, $permissionId);

    public function all(): Collection;
}
