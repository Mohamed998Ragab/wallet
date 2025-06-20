<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Modules\Permission\Services\PermissionServiceInterface;

class AdminSeeder extends Seeder
{
    protected $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function run()
    {
        $admin1 = Admin::create([
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'wallet_id' => 1,
            'is_superadmin' => 1,
        ]);

        $admin2 = Admin::create([
            'name' => 'Admin Two',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'wallet_id' => 2,
            'is_superadmin' => 0,
        ]);

        $this->permissionService->assignPermission($admin1->id, 'accept_withdrawals');
        $this->permissionService->assignPermission($admin1->id, 'reject_withdrawals');
        $this->permissionService->assignPermission($admin1->id, 'manage_withdrawals');
        $this->permissionService->assignPermission($admin2->id, 'accept_topup');
        $this->permissionService->assignPermission($admin2->id, 'reject_topup');
        $this->permissionService->assignPermission($admin2->id, 'manage_topups');
    }
}