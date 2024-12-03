<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションの実行
     */
    public function up(): void
    {
        Schema::table('timers', function (Blueprint $table) {
            // file_id カラムを追加
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade')->comment('公開ファイルID');
        });
    }

    /**
     * マイグレーションの巻き戻し
     */
    public function down(): void
    {
        Schema::table('timers', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
            $table->dropColumn('file_id');
        });
    }
};
