<?php

namespace Modules\Wallet\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Models\Admin;
use Modules\Transaction\Models\Transaction;
use Modules\User\Models\User;

class Wallet extends Model
{
    protected $fillable = ['balance', 'held_balance'];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}