<?php

namespace Modules\Wallet\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Wallet\Models\Wallet;

class WalletSeeder extends Seeder
{
    public function run()
    {
        Wallet::create(['balance' => 1000.00, 'held_balance' => 0.00]);
        Wallet::create(['balance' => 500.00, 'held_balance' => 0.00]);
    }
}