<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Kasir extends Authenticatable
{
    use HasFactory;

    protected $table = 'kasirs';
    protected $primaryKey = 'id_kasir';

    protected $fillable = [
        'nama_kasir',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class, 'id_kasir', 'id_kasir');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_kasir', 'id_kasir');
    }
}
