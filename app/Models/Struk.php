<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_struk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_struk',
        'id_transaksi',
        'tanggal_cetak',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
