<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    use HasFactory;

    protected $table = 'struks';
    protected $primaryKey = 'id_struk';
    public $incrementing = false; // biasanya id_struk seperti "NSTR20251107-1"
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
