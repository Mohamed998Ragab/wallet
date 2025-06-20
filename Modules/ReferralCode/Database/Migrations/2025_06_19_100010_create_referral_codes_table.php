<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralCodesTable extends Migration
{
    public function up()
    {
        Schema::create('referral_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->unique();
            $table->unsignedBigInteger('generator_id');
            $table->string('generator_type', 255);
            $table->foreignId('used_by_user_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('referral_codes');
    }
}