<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('permission_id');
            $table->primary(['user_id','permission_id']);
        });
        Schema::create('users_roles', function (Blueprint $table) {
            $table->foreignId('user_id');
            $table->foreignId('role_id');
            $table->primary(['user_id','role_id']);
        });
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->foreignId('role_id');
            $table->foreignId('permission_id');
            $table->primary(['role_id','permission_id']);
        });
        Artisan::call('db:seed', [
            '--class' => 'RoleSeeder',
            '--force' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_permissions');
        Schema::dropIfExists('users_roles');
        Schema::dropIfExists('users_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
