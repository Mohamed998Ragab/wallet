<?php

namespace Modules\Transaction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Transaction\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        Transaction::create([
            'wallet_id' => 1,
            'amount' => 100.00,
            'type' => 'referral_bonus',
        ]);
        Transaction::create([
            'wallet_id' => 2,
            'amount' => 50.00,
            'type' => 'top_up',
            'request_id' => 1,
            'request_type' => 'top_up',
        ]);
    }
}