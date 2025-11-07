<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_transaksi');

            // 🔢 Kode unik transaksi (misal: TRX20251107-1)
            $table->string('kode_transaksi')->unique();

            // 🧍‍♂️ Relasi ke kasir
            $table->unsignedBigInteger('id_kasir');
            $table->foreign('id_kasir')->references('id_kasir')->on('kasirs')->onDelete('cascade');

            // 📅 Info transaksi utama
            $table->dateTime('tanggal');
            $table->decimal('total_harga', 12, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer']);
            $table->decimal('uang_diterima', 12, 2)->nullable();
            $table->decimal('kembalian', 12, 2)->nullable();

            // 🏦 Info tambahan untuk metode transfer (opsional)
            $table->string('tipe_transfer')->nullable();   // bank / ewallet
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_ewallet')->nullable();
            $table->string('nomor_ewallet')->nullable();
            $table->string('nama_pengirim')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
