<?php

namespace Modules\Permission\Services;

use Modules\Permission\Repositories\PermissionRepositoryInterface;
use Modules\Permission\Services\PermissionServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Admin\Models\Admin;

class PermissionService implements PermissionServiceInterface
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function all(): Collection
    {
        return $this->permissionRepository->all();
    }

    public function hasPermission($adminId, $permissionName)
    {
        $permission = $this->permissionRepository->findByName($permissionName);
        return $permission->admins()->where('admin_id', $adminId)->exists();
    }

    public function assignPermission($adminId, $permissionName): bool
    {
        try {
            $permission = $this->permissionRepository->findByName($permissionName);
            $this->permissionRepository->assignToAdmin($adminId, $permission->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function bulkAssignPermissions($adminId, array $permissionIds): bool
    {
        try {
            $admin = Admin::findOrFail($adminId);
            $admin->permissions()->sync($permissionIds);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function removePermission($adminId, $permissionName): bool
    {
        try {
            $admin = Admin::findOrFail($adminId);
            $permission = $this->permissionRepository->findByName($permissionName);
            $admin->permissions()->detach($permission->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAdminPermissions($adminId): Collection
    {
        $admin = Admin::with('permissions')->find($adminId);
        return $admin ? $admin->permissions : collect();
    }
}
