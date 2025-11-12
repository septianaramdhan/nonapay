<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 🩶 tambahin ini

class Produk extends Model
{
    use HasFactory, SoftDeletes; // 🩶 aktifkan soft delete

    protected $table = 'produks';
    protected $primaryKey = 'id_produk';
    public $incrementing = true; // tambahkan untuk id auto increment

    protected $fillable = [
        'id_kasir',
        'nama_produk',
        'harga',
        'stok',
    ];

    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'id_kasir', 'id_kasir');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }
}
