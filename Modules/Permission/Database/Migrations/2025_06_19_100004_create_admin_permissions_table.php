<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->foreignId('admin_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->primary(['admin_id', 'permission_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}