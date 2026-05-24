<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tentukan path asal (Master Asset) dan path tujuan (Storage Publik)
        $sourcePath = database_path('seeders/seed-assets');
        $destinationPath = storage_path('app/public');

        // 2. Pastikan folder master asset ada sebelum disalin
        if (!File::exists($sourcePath)) {
            $this->command->error("Folder master asset tidak ditemukan di: {$sourcePath}");
            return;
        }

        // 3. Pastikan folder storage tujuan sudah dibuat
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // 4. Proses penyalinan folder produk-images
        $sourceImages = $sourcePath . '/produk-images';
        $destImages = $destinationPath . '/produk-images';

        if (File::exists($sourceImages)) {
            File::copyDirectory($sourceImages, $destImages);
            $this->command->info('Aset gambar produk berhasil disalin ke storage!');
        }

        // 5. Proses penyalinan folder ebooks (PDF)
        $sourceEbooks = $sourcePath . '/ebooks';
        $destEbooks = $destinationPath . '/ebooks';

        if (File::exists($sourceEbooks)) {
            File::copyDirectory($sourceEbooks, $destEbooks);
            $this->command->info('Aset file PDF E-book berhasil disalin ke storage!');
        }
    }
}
