<?php

namespace Modules\Permission\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Admin\Models\Admin;

class AssignPermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only superadmin can assign permissions
        return auth('admin')->check() && auth('admin')->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'admin_id' => [
                'required', 
                'exists:admins,id',
                'different:' . auth('admin')->id(), // Can't assign to self
                function ($attribute, $value, $fail) {
                    $admin = Admin::find($value);
                    if ($admin && $admin->isSuperAdmin()) {
                        $fail('Cannot assign permissions to super admin.');
                    }
                }
            ],
            'permission_id' => ['required', 'exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'admin_id.different' => 'You cannot assign permissions to yourself.',
            'admin_id.exists' => 'The selected admin does not exist.',
            'permission_id.exists' => 'The selected permission does not exist.',
        ];
    }
}