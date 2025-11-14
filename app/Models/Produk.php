<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produks';
    protected $primaryKey = 'id_produk';

    public $incrementing = false; // WAJIB
    protected $keyType = 'string'; // WAJIB

    protected $fillable = [
        'id_produk',
        'id_kasir',
        'nama_produk',
        'harga',
        'stok',
        'gambar',
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
