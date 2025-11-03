<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Struk extends Model
{
    use HasFactory;

    protected $table = 'struks';
    protected $primaryKey = 'id_struk';

    protected $fillable = [
        'id_transaksi',
        'tanggal_cetak',
    ];

public function transaksi()
{
    return $this->belongsTo(Transaksi::class, 'id_transaksi');
}

}
