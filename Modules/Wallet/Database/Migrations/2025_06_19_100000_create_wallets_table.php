<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->decimal('held_balance', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}