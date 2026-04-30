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
        Schema::create('aset_produks', function (Blueprint $table) {
            $table->id('id_aset');
            $table->foreignId('id_produk')->constrained('produks', 'id_produk')->onDelete('cascade');

            // Untuk E-book: Simpan Nama Buku atau Untuk Akun: Simpan Username/ID Akun
            $table->string('nama_aset');

            // Untuk E-book: Simpan path file (misal: ebooks/laravel-guide.pdf)
            $table->string('link_file')->nullable();

            // Untuk Akun: Simpan detail asset seperti username, password, atau informasi penting lainnya
            $table->text('deskripsi')->nullable();
            $table->boolean('is_sold')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_produks');
    }
};
