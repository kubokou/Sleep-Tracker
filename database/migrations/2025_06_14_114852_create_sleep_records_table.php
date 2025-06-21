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
        Schema::create('sleep_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK
            $table->date('date'); // 記録日
            $table->time('sleep_time'); // 就寝時間
            $table->time('wake_time'); // 起床時間
            $table->decimal('duration', 4, 2); // 睡眠時間（例: 7.5 時間）
            $table->text('memo')->nullable(); // メモ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sleep_records');
    }
};
