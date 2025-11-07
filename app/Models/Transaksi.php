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
        'id_kasir',
        'tanggal',
        'total_harga',
        'metode_pembayaran',
        'uang_diterima',
        'kembalian',
    ];

    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'id_kasir', 'id_kasir');
    }

 public function detailTransaksi()
{
    return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
}

    public function struk()
    {
        return $this->hasMany(Struk::class, 'id_transaksi', 'id_transaksi');
    }
}
