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
        Schema::create('brands', function (Blueprint $table) {
            $table->id('id_brand'); // Primary Key
            $table->unsignedBigInteger('id_kategori'); // Menghubungkan ke tabel kategori murni
            $table->string('nama_brand'); // Tempat menyimpan nama "Netflix", "Mobile Legend", dll
            $table->string('gambar_brand')->nullable(); // Opsional, jika brand butuh logo/banner
            $table->timestamps();

            // Hubungkan Foreign Key ke tabel kategoris Anda
            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
