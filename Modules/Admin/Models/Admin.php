<?php

namespace Modules\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Wallet\Models\Wallet;
use Modules\Permission\Models\Permission;
use Illuminate\Notifications\Notifiable; 

class Admin extends Authenticatable
{
    use Notifiable; // Add this trait

    protected $fillable = ['name', 'email', 'password', 'wallet_id'];

    protected $casts = [
        'is_superadmin' => 'boolean',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_permissions');
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_superadmin;
    }

    public function hasPermission(string $permission): bool
    {
        // Superadmin has all permissions
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->permissions()->where('name', $permission)->exists();
    }
}
