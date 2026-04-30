<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetProduk extends Model
{
    use HasFactory;

    protected $table = 'aset_produks';
    protected $primaryKey = 'id_aset';

    protected $fillable = [
        'id_produk',
        'nama_aset',
        'link_file',
        'deskripsi',
        'is_sold'
    ];

    // Cast is_sold sebagai boolean
    protected $casts = [
        'is_sold' => 'boolean',
    ];

    // Relasi balik ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
