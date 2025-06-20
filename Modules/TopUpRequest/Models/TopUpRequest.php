<?php

namespace Modules\TopUpRequest\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Admin;
use Modules\User\Models\User;

class TopUpRequest extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'approved_by_admin_id');
    }
}