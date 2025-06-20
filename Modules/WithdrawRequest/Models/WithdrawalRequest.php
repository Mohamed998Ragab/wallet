<?php

namespace Modules\WithdrawRequest\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Admin;

class WithdrawalRequest extends Model
{
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function approvedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'approved_by_admin_id');
    }
}