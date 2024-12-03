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
        if (!Schema::hasTable('timers')) {
            Schema::create('timers', function (Blueprint $table) {
                $table->id();
                $table->uuid('uuid')->comment('UUID');
                $table->string('name')->comment('名前');
                $table->date('date')->comment('起動日時');
                $table->string('note')->comment('備考');
                $table->timestamps();
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
