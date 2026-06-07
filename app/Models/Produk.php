<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_brand',
        'nama_produk',
        'deskripsi_produk',
        'harga_produk',
        'gambar_produk'
    ];

    // Relasi balik ke Kategori
    // public function kategori()
    // {
    //     return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    // }

    // Hapus relasi kategori lama, ganti dengan ini:
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand', 'id_brand');
    }

    // Relasi ke Aset Produk (Akun/File)
    public function asets()
    {
        return $this->hasMany(AsetProduk::class, 'id_produk', 'id_produk');
    }
}
