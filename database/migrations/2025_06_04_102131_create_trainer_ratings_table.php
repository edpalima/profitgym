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
        Schema::create('trainer_ratings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('trainer_id')->constrained();
        $table->foreignId('user_id')->constrained();
        $table->tinyInteger('rating');
        $table->text('feedback')->nullable();
        $table->boolean('recommend');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_ratings');
    }
};
