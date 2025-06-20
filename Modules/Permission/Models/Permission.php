<?php

namespace Modules\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Admin;

class Permission extends Model
{
    protected $fillable = ['name'];

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_permissions');
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function getDisplayNameAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->name));
    }
}