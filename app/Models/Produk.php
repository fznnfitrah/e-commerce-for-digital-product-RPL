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
        'id_kategori', 
        'nama_produk', 
        'deskripsi_produk', 
        'harga_produk',     
        'gambar_produk'
    ];

    // Relasi balik ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke Aset Produk (Akun/File)
    public function asets()
    {
        return $this->hasMany(AsetProduk::class, 'id_produk', 'id_produk');
    }
}
