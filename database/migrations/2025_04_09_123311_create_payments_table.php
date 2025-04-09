<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['user_membership', 'products']);
            $table->unsignedBigInteger('type_id');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['over_the_counter', 'gcash'])->default('over_the_counter');
            $table->string('status')->default('pending');
            $table->dateTime('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
