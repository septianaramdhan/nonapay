<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['nama','harga','stok','satuan'];
    public function details(){ return $this->hasMany(TransactionDetail::class); }
}
