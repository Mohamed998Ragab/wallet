<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Withdrawal permissions
            'accept_withdrawals',
            'reject_withdrawals',
            'manage_withdrawals',
            'view_withdrawals',
            
            // Top-up permissions
            'accept_topup',
            'reject_topup',
            'manage_topups',
            'view_topups',
            
            // Admin management permissions
            'manage_admins',
            'view_admins',
            'create_admins',
            'edit_admins',
            'delete_admins',
            
            // Permission management
            'manage_permissions',
            'assign_permissions',
            'view_permissions',
            
            // Referral permissions
            'manage_referrals',
            'generate_referrals',
            'view_referrals',
            
            // Wallet permissions
            'view_wallets',
            'manage_wallets',
            'view_wallet_transactions',
            
            // User management permissions
            'view_users',
            'manage_users',
            'suspend_users',
            'activate_users',
            
            // Dashboard permissions
            'view_dashboard',
            'view_reports',
            'view_analytics',
            
            // System permissions
            'manage_settings',
            'view_logs',
            'backup_system',
            'maintenance_mode',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        
        $this->command->info('Permissions seeded successfully!');
    }
}