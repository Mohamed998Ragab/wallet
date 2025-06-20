<?php

namespace Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Models\Wallet;

class Transaction extends Model
{
    protected $fillable = ['wallet_id', 'amount', 'type', 'request_id', 'request_type'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}