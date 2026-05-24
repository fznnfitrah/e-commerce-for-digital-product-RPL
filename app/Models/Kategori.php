<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';

    // Mass assignment protection
    protected $fillable = ['nama_kategori'];

    // Relasi ke Produk: Satu kategori punya banyak produk
    // public function produks()
    // {
    //     return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    // }
    public function brands()
    {
        return $this->hasMany(Brand::class, 'id_kategori', 'id_kategori');
    }

    // Opsional: Jika ingin mengambil semua produk di dalam kategori ini lewat Brand
    public function produks()
    {
        return $this->hasManyThrough(Produk::class, Brand::class, 'id_kategori', 'id_brand', 'id_kategori', 'id_brand');
    }
}
