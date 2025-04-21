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
            $table->enum('payment_method', ['OVER_THE_COUNTER', 'GCASH'])->default('OVER_THE_COUNTER');
            $table->string('image')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('status')->default('PENDING');
            $table->dateTime('payment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
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
