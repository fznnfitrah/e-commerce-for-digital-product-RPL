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
        Schema::create('sim_providers', function (Blueprint $table) {
            $table->id('id_provider');
            $table->string('nama_provider');
            $table->string('prefix_nomor'); // Contoh: 0812, 0878
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sim_providers');
    }
};
