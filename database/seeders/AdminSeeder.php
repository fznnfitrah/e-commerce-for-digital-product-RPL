<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan updateOrCreate agar tidak terjadi duplikat jika dijalankan berkali-kali
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Cari berdasarkan email ini
            [
                'name'     => 'admin',
                'password' => Hash::make('admin123'), // Ini akan mengubah 'admin123' menjadi hash Bcrypt
                'role'     => 'admin', // Memastikan role terisi sesuai tabel Anda
            ]
        );
    }
}
