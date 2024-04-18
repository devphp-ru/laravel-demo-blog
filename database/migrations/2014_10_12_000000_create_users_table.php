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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->string('name')->comment('Имя');
            $table->string('email')->unique()->comment('Email');
            $table->timestamp('email_verified_at')->nullable()->comment('Под. email');
            $table->string('password')->comment('Пароль');
            $table->rememberToken()->comment('Токен');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
