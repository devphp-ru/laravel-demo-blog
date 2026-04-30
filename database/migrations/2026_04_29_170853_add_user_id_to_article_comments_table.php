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
        Schema::table('article_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default(0)->comment('ID пользователя')->index()->after('article_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('article_comments', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
