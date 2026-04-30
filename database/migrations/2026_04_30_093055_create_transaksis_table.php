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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_users')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('id_produk')->constrained('produks', 'id_produk');
            $table->foreignId('id_promo')->nullable()->constrained('promos', 'id_promo');
            $table->string('id_target'); // Untuk ID Game
            $table->string('id_server')->nullable(); // Untuk Server Game
            $table->string('kontak_pelanggan'); // Email/WA untuk Guest
            $table->decimal('total_pembelian', 15, 2);
            $table->decimal('diskon_pembelian', 15, 2)->default(0);
            $table->decimal('total_akhir', 15, 2);
            $table->string('metode_pembayaran');
            $table->enum('status_pembayaran', ['pending', 'success', 'failed'])->default('pending');
            $table->text('sn_token_result')->nullable(); // Hasil SN/Token
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
