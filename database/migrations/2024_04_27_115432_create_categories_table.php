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
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->bigInteger('parent_id')->unsigned()->default(0)->index()->comment('ID родителя');
            $table->string('slug')->unique()->index()->comment('ЧПУ');
            $table->string('name')->unique()->comment('Название');
            $table->text('content')->nullable()->comment('Описание');
            $table->boolean('is_active')->default(true)->comment('Активность');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
