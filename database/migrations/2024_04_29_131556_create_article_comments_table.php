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
        Schema::create('article_comments', function (Blueprint $table) {
            $table->id()->comment('ID');
            $table->bigInteger('parent_id')->unsigned()->default(0)->index()->comment('ID родителя');
            $table->foreignId('article_id')->unsigned()->index()->comment('ID статьи');
            $table->string('username')->comment('Имя');
            $table->string('email')->comment('Email');
            $table->string('comment')->comment('Комментарий');
            $table->boolean('is_active')->default(false)->comment('Активность');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_comments');
    }
};
