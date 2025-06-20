<?php

namespace Modules\Permission\Controllers;

use App\Http\Controllers\Controller;
use Modules\Permission\Requests\AssignPermissionRequest;
use Modules\Permission\Services\PermissionServiceInterface;
use Modules\Permission\Resources\PermissionResource;
use Modules\Admin\Models\Admin;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected PermissionServiceInterface $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function index()
    {
        $permissions = $this->permissionService->all();
        $admins = Admin::where('is_superadmin', false)->get();
        
        return view(
            'admin::admin.permissions.index',
            [
                'permissions' => PermissionResource::collection($permissions),
                'admins' => $admins,
            ]
        );
    }

    public function assign(AssignPermissionRequest $request)
    {
        $this->permissionService->assignPermission(
            $request->admin_id,
            $request->permission_id
        );

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission assigned successfully.');
    }

    public function bulkAssign(Request $request)
    {
        $request->validate([
            'admin_id' => ['required', 'exists:admins,id'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $admin = Admin::findOrFail($request->admin_id);
        
        // Sync permissions (this will add new ones and remove unchecked ones)
        $admin->permissions()->sync($request->permissions);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permissions updated successfully for ' . $admin->name . '.');
    }

    public function getAdminPermissions(Request $request)
    {
        $admin = Admin::with('permissions')->findOrFail($request->admin_id);
        return response()->json([
            'permissions' => $admin->permissions->pluck('id')->toArray()
        ]);
    }
}