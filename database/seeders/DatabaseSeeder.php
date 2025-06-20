<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            \Modules\Wallet\Database\Seeders\WalletSeeder::class,
            \Modules\Permission\Database\Seeders\PermissionSeeder::class,
            \Modules\Admin\Database\Seeders\AdminSeeder::class,
            \Modules\Transaction\Database\Seeders\TransactionSeeder::class,
        ]);
    }
}