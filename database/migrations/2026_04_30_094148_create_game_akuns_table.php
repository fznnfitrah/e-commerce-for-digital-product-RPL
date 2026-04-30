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
        Schema::create('game_akuns', function (Blueprint $table) {
            $table->id('id_game_akun');
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade');
            $table->string('label_akun'); 
            $table->string('id_game');
            $table->string('id_server_game')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_akuns');
    }
};
