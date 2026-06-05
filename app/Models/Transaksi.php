<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_users',
        'id_produk',
        'id_promo',
        'id_target',
        'id_server',
        'kontak_pelanggan',
        'total_pembelian',
        'diskon_pembelian',
        'total_akhir',
        'metode_pembayaran',
        'status_pembayaran',
        'snap_token',
        'sn_token_result'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'id_transaksi', 'id_transaksi');
    }
}
