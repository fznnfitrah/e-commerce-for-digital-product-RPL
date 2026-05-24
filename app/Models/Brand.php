<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = 'id_brand';
    protected $fillable = ['id_kategori', 'nama_brand', 'gambar_brand'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_brand', 'id_brand');
    }
}