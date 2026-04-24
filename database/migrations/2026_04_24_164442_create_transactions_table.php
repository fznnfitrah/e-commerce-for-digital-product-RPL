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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique(); // Format: JSTR-20240424-XXXX
            $table->foreignId('user_id')->nullable()->constrained(); // Null for Guest
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('target_data'); // Game ID, Phone Number, etc.
            $table->decimal('total_price', 15, 2);
            $table->string('payment_status')->default('pending'); // pending, success, failed
            $table->string('payment_method')->default('QRIS');
            $table->string('snap_token')->nullable(); // For Midtrans integration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
