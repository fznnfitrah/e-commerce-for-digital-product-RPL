<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id_promo';

    protected $fillable = [
        'kode_promo',
        'potongan_harga',
        'batasan_user',
        'transaksi_min'
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_promo', 'id_promo');
    }
}
