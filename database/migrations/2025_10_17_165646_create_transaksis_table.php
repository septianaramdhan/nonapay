<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('transaksis', function (Blueprint $table) {
        $table->id('id_transaksi');
        $table->unsignedBigInteger('id_kasir');
        $table->date('tanggal');
        $table->decimal('total_harga', 12, 2);
        $table->enum('metode_pembayaran', ['cash', 'transfer']);
        $table->decimal('uang_diterima', 12, 2)->nullable();
        $table->decimal('kembalian', 12, 2)->nullable();
        $table->timestamps();

        $table->foreign('id_kasir')->references('id_kasir')->on('kasirs')->onDelete('cascade');
    });
}


    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
