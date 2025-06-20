<?php 

namespace Modules\ReferralCode\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class ReferralCode extends Model
{
    protected $guarded = [];

    public function generator()
    {
        return $this->morphTo();
    }

    public function usedByUser()
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }
}