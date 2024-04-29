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
        Schema::create('articles', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->foreignId('category_id')->unsigned()->index()->comment('ID категории');
            $table->string('slug')->unique()->index()->comment('ЧПУ');
            $table->string('title')->unique()->comment('Название');
            $table->text('content')->comment('Текс');
            $table->string('thumbnail')->nullable()->comment('Изображение');
            $table->bigInteger('views')->default(0)->comment('Просмотры');
            $table->boolean('is_active')->default(true)->comment('Активность');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
