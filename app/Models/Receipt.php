<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {
    protected $fillable = ['transaction_id','tanggal_cetak','total','metode_payment','kembalian'];
    public function transaction(){ return $this->belongsTo(Transaction::class); }
}
