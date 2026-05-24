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
        Schema::table('produks', function (Blueprint $table) {
            // Tambahkan kolom id_brand setelah kolom id_kategori lama
            $table->unsignedBigInteger('id_brand')->nullable()->after('id_kategori');

            // Set Foreign Key ke tabel brands
            $table->foreign('id_brand')->references('id_brand')->on('brands')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropForeign(['id_brand']);
            $table->dropColumn('id_brand');
        });
    }   
};
