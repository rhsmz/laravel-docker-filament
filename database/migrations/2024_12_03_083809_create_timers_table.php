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
        Schema::create('timers', function (Blueprint $table) {
            $table->comment('タイマーを管理するテーブル');
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->comment('名前');
            $table->date('date')->comment('起動日時');
            $table->string('note')->comment('備考');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade')->comment('公開ファイルID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
