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
        Schema::create('files', function (Blueprint $table) {
            $table->comment('ファイルを管理するテーブル');
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->comment('名前');
            $table->string('filename')->comment('ファイル名');
            $table->string('path')->comment('ファイルパス');
            $table->string('note')->comment('備考');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
