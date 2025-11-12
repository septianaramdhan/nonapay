<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksis';
    protected $primaryKey = 'id_detail';
    public $incrementing = true;

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'nama_produk', // 🩶 snapshot nama produk
        'harga_saat_transaksi', // 🩶 snapshot harga produk
        'jumlah',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function produk()
    {
        // 🧊 Produk bisa aja null kalau dihapus permanen, jadi relasi optional
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk')->withTrashed();
    }
}
