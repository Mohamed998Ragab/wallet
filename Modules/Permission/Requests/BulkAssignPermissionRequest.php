<?php

namespace Modules\Permission\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkAssignPermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check() && auth('admin')->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'admin_id' => ['required', 'exists:admins,id'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'admin_id.required' => 'Please select an admin.',
            'admin_id.exists' => 'Selected admin does not exist.',
            'permissions.array' => 'Permissions must be an array.',
            'permissions.*.exists' => 'One or more selected permissions do not exist.',
        ];
    }

    public function attributes(): array
    {
        return [
            'admin_id' => 'admin',
            'permissions' => 'permissions',
        ];
    }
}