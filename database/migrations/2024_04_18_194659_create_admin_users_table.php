<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('username')->comment('Имя');
            $table->string('email')->unique()->comment('Email');
            $table->string('password')->comment('Пароль');
            $table->boolean('is_banned')->default(false)->comment('Бан');
            $table->rememberToken()->comment('Токен');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_users');
    }
};
