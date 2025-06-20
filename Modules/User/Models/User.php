<?php

namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Wallet\Models\Wallet;
use Modules\ReferralCode\Models\ReferralCode;

class User extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = ['name', 'email', 'password', 'wallet_id', 'referral_code', 'referred_by_id'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function referralCodes()
    {
        return $this->morphMany(ReferralCode::class, 'generator');
    }

    public function referredBy()
    {
        return $this->belongsTo(self::class, 'referred_by_id');
    }

    public function referrals()
    {
        return $this->hasMany(self::class, 'referred_by_id');
    }
}